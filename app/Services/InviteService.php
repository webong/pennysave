<?php

namespace App\Services;

use App\User;
use App\GroupInvite;
use App\Mail\InviteUser;
use App\Services\TeamService;
use App\Services\UserService;
use App\Jobs\SendInvitationEmail;
use App\Jobs\SendInvitationSMS;
use Carbon\Carbon;
use Auth;
use DB;

class InviteService
{
    protected $confirmedEmails = array();
    protected $confirmedPhoneNos = array();
    protected $previous = array();
    protected $request;
    protected $team_id;
    protected $user;
    protected $when;
    protected $message = '';

    public function __construct(TeamService $teamService, UserService $userService)
    {
        $this->teamService = $teamService;
        $this->when = Carbon::now()->addMinutes(5);
        $this->userService = $userService;
    }

    public function invite($request, $team_id, $user, $list = false)
    {
        $this->request = $request;
        $this->team_id = $team_id;
        $this->user = $user;
        $this->validateUniqueInArrayOrList($list);
        if (count($this->confirmedEmails) > 0) {
            // Email Addresses are arranged in arrays
            $status = $this->sendMail($this->confirmedEmails);
            if (count($this->confirmedPhoneNos) > 0) {
                // Phones Numbers are arranged as comma-seperated values
                $status = $this->sendSMS($this->confirmedPhoneNos);
            }
        } elseif (count($this->confirmedPhoneNos)) {
            // Phones Numbers are arranged as comma-seperated values
            $status = $this->sendSMS($this->confirmedPhoneNos);
        } else {
            $status = $this->previous;
        }
        return $this->handleStatuses($status);
    }

    public function validateUniqueInArrayOrList($list = false)
    {
        if ($list) {
            $getEmails = explode(',', $this->request->emails);
            // Filtering Duplicates and Null values
            (array) $getEmails = array_filter(array_unique($getEmails));
            for ($i = 0; $i < count($getEmails); $i++) {
                $getEmails[$i] = trim($getEmails[$i]);
                if ($this->skipSendersEmailOrPhone($getEmails[$i])) continue;
                
                if (filter_var($getEmails[$i], FILTER_VALIDATE_EMAIL)) {
                    if (! $this->confirmPreviousInviteByEmail($getEmails[$i])) {
                        if (is_null($this->currentUser($getEmails[$i]))) {
                            $this->confirmedEmails[] = $getEmails[$i];
                        } else {
                            $this->previous['already'][] = $getEmails[$i];
                        }
                    } elseif ($this->confirmPreviousInviteByPhone($getEmails[$i])) {
                        dd($getEmails[$i]);
                        $this->confirmedPhoneNos = $getEmails[$i] . ', ';
                    }
                } else {
                    if ($this->confirmPreviousInviteByPhone($getEmails[$i])) {
                        dd($getEmails[$i]);
                        $this->confirmedPhoneNos = $getEmails[$i] . ', ';
                    } else {
                        $this->previous['invalid'][] = $getEmails[$i];
                    }
                }
            }
        } else {
            // Filtering Duplicates and Null values
            (array) $this->request->email = array_filter(array_unique($this->request->email));
            (array) $this->request->phone = array_filter(array_unique($this->request->phone));
    
            if (count($this->request->email) > 0) {
                foreach ($this->request->email as $key => $current_email) {
                    if ($this->skipSendersEmailOrPhone($current_email)) continue;
                    if (filter_var($current_email, FILTER_VALIDATE_EMAIL)) {
                        if (! $this->confirmPreviousInviteByEmail($current_email)) {
                            if (is_null($this->currentUser($current_email))) {
                                $this->confirmedEmails['get'][] = $current_email;
                                $this->confirmedEmails['get'][] = (isset($this->request->first_name[$key]))
                                                            ? $this->request->first_name[$key] : null;
                                // dd($this->confirmedEmails);
                            } else {
                                $this->previous['already'][] = $current_email;
                            }
                        }
                    } else {
                        $this->previous['invalid'][] = $current_email;
                    }
                }
            }
            if (count($this->request->phone) > 0) {
                foreach ($this->request->phone as $i => $current_phone) {
                    if ($this->confirmPreviousInviteByPhone($current_phone)) {
                        $this->confirmedPhoneNos = $current_phone . ', ';
                    }
                }
            }
        }
    }

    public function skipSendersEmailOrPhone($emailOrPhone) {
        if ($emailOrPhone == Auth::user()->email || $emailOrPhone == Auth::user()->phone) {
            $this->message = "You can't send an invitation to yourself";
            return true;
        }
        return false;
    }

    public function confirmPreviousInviteByEmail($email)
    {
        $previousInvite = GroupInvite::where('email', $email)->where('team_id', $this->team_id)->first();
        return ($previousInvite) ? $this->analyzeResponse($previousInvite, $email) : false;
    }

    public function confirmPreviousInviteByPhone($phone)
    {
        $previousInvite = GroupInvite::where('phone', $phone)->where('team_id', $this->team_id)->first();
        return ($previousInvite) ? $this->analyzeResponse($previousInvite, $phone) : false;
    }

    public function analyzeResponse($previousInvite, $emailOrPhone)
    {
        if ($previousInvite->status == 'waiting') {
            $this->previous['awaiting'][] = $emailOrPhone;
            return true;
        } elseif ($previousInvite->status == 'accepted') {
            $this->previous['already'][] = $emailOrPhone;
            return true;
        } elseif ($previousInvite->status == 'declined') {
            $this->previous['declined'][] = $emailOrPhone;
            return true;
        }
    }

    public function currentUser($email)
    {
        return $currentUser = User::where('email', $email)
            ->whereHas('group', function($query) {
                $query->where('id', $this->team_id);
            })->first();
    }

    public function generateInviteLink($emailOrPhone, $team_id)
    {
        return $this->request->root() . '/team/'. $team_id .'/invite/' . encrypt($emailOrPhone);
    }

    public function sendMail($confirmedEmails)
    {
        foreach ($confirmedEmails as $email) {
            if (is_array($email)) {
                $job = (new SendInvitationEmail($email[0], $this->generateInviteLink($email[0], $this->team_id),
                        $this->teamService->getTeam($this->team_id), $this->request->message, 
                        $this->user->full_name(), $email[1]))->delay($this->when);
                dispatch($job);
                $this->status['sent'][] = ($this->saveInviteRecord($email[0], 'email')) ? true : false;
            } else {
                $job = (new SendInvitationEmail($email, $this->generateInviteLink($email, $this->team_id),
                        $this->teamService->getTeam($this->team_id), $this->request->message, 
                        $this->user->full_name(), null))->delay($this->when);
                dispatch($job);
                $this->status['sent'][] = ($this->saveInviteRecord($email, 'email')) ? true : false;
            } 
        }
        return $this->status;
    }

    public function saveInviteRecord($emailOrPhone, $whichType)
    {
        if ($whichType == 'phone') {
            foreach ($emailOrPhone as $phone) {
                $groupInvite = new GroupInvite;
                $groupInvite->id = gen_uuid();
                $groupInvite->email = 'N/A';
                $groupInvite->phone = $phone;
                $groupInvite->inviter_id = Auth::user()->id;
                $groupInvite->team_id = $this->team_id;
                if ($groupInvite->save()) {
                    continue;
                }
            }
            return true;
        }
        $groupInvite = new GroupInvite;
        $groupInvite->id = gen_uuid();
        $groupInvite->email = $emailOrPhone;
        $groupInvite->phone = 'N/A';
        $groupInvite->inviter_id = Auth::user()->id;
        $groupInvite->team_id = $this->team_id;
        if ($groupInvite->save()) {
            return true;
        }
        return false;
    }

    public function handleStatuses($status)
    {
        if (isset($status['sent'])) {
            $this->message = (count($status['sent']) > 1) ?
                'Your Invitations were sent successfully <br />' :
                'Your Invitation was sent successfully <br />';
            unset($status['sent']);
            if (count($status) > 0) {
                foreach ($status as $key => $currentStatus) {
                    $this->message .= $this->returnAnalysis($currentStatus, $key, true);
                }
            }
        } else {
            foreach ($status as $key => $currentStatus) {
                $this->message .= $this->returnAnalysis($currentStatus, $key);
            }
        }
        // Remove final Break Tag at the end of line
        rtrim($this->message, '<br />');
        return $this->message;
    }

    public function returnAnalysis($status, $setTitle, $added = false)
    {
        $awaiting = '';
        if (($setTitle != 'awaiting' || $setTitle != 'declined') && $added): $however = 'Also, ';
        elseif (($setTitle == 'awaiting' or $setTitle == 'declined') && $added): $however = '<br />However, ';
        else: $however = '';
        endif;
        if (count($status) > 1) {
            $member = ' members ';
            $invitation = 'invitations';
            if ($setTitle == 'accepted' || $setTitle == 'declined'):
                $verb = ' have';
            else: $verb = ' are';
            endif;
        } else {
            $member = ' a member ';
            $invitation = 'invitation';
            if ($setTitle == 'declined'): $verb = ' has';
            else: $verb = ' is';
            endif;
        }
        if ($setTitle == 'awaiting'): $statement = ' yet to accept the previous invitation <br />';
        elseif ($setTitle == 'already'): $statement = ' already ' . $member . 'of the team <br />';
        elseif ($setTitle == 'declined'): $statement = ' declined to join the team <br />';
        elseif ($setTitle == 'invalid'): $statement = ' invalid! <br />';
        endif;
        foreach ($status as $theEmail) {
            $awaiting .= ($first_name = $this->userService->getFirstName($theEmail)) ?
                $first_name  . ', ' :
                $thisEmail . ', ';
        }
        $finalList = rtrim($awaiting, ', ');
        return $however . '<strong>' . $finalList . '</strong>' . $verb . $statement;
    }

    public function sendSMS($phoneNumbers)
    {
        $finalList = rtrim($phoneNumbers, ', ');
        // Job to Send SMS
        // $job = (new SendInvitationSMS($finalList))->delay($this->when);
        // dispatch($job);
        $this->status['sent'][] = ($this->saveInviteRecord($finalList, 'phone')) ? true : false;
    }

    public function inviteRegister($team_id, $invite_token)
    {
        try {
            $invitedEmailOrPhone = decrypt($invite_token);
        } catch (\Exception $e) {
            return $response = 'invalid';
        }
        $confirmInvite = GroupInvite::where('email', $invitedEmailOrPhone)
            ->orWhere('phone', $invitedEmailOrPhone)
            ->where('status', 'awaiting')->first();
        if ($confirmInvite) {
            $checkIfAlreadyUser = User::where('email', $invitedEmailOrPhone)
                ->orWhere('phone', $invitedEmailOrPhone)->first();
            if ($checkIfAlreadyUser) {
                return $invitedEmailOrPhone;
            } else {
                if (! is_null($confirmInvite->email)) {
                    $data['invitationEmail'] = $confirmInvite->email;
                    return $data;
                } else {
                    $data['invitationPhone'] = $confirmInvite->phone;
                    return $data;
                }
            }
        } else {
            return $response = 'expired';
        }
    }

    public function checkInvites()
    {
        return GroupInvite::where(function ($query) {
                $query->where('email', Auth::user()->email)
                ->orWhere('phone', Auth::user()->phone);
            })->where('status', 'waiting')->get();
    }

    public function getAllInvites()
    {
        return GroupInvite::where(function ($query) {
                $query->where('email', Auth::user()->email)
                ->orWhere('phone', Auth::user()->phone);
            })->where('status', 'waiting')
            ->with('group', 'user', 'invited')->get();            
    }

    public function inviteResponse($request)
    {
        if ($request->invite_response == 'accept-invite') {
            if ($this->teamService->registerMemberToTeam(Auth::user()->id, $request->team_id)) {
                return $this->updateInviteStatus('accepted', $request->team_id, $request->inviter_id);
            }
        } elseif ($request->invite_response == 'reject-invite') {
            return $this->updateInviteStatus('declined', $request->team_id, $request->inviter_id);
        }
        return false; 
    }

    public function updateInviteStatus($responseType, $team_id, $inviter_id)
    {
        GroupInvite::where('team_id', $team_id)
            ->where('inviter_id', $inviter_id)
            ->where('email', User::find(Auth::user()->id)->email)
            ->orWhere('phone', User::find(Auth::user()->id)->phone)
            ->where('status', 'waiting')
            ->update(['status' => $responseType]);
        return $responseType;
    }

    public function updateInviteStatusOnRegister($responseType, $team_id, $request)
    {
        if (isset($request['email']) && $request['email'] != '') {
            $column = 'email';
            $value = $request['email'];
        } else {
            $column = 'phone';
            $value = $request['phone'];
        }
        GroupInvite::where('team_id', $team_id)
            ->where($column, $value)
            ->where('status', 'waiting')
            ->update(['status' => $responseType]);
        return $responseType;
    }
}
