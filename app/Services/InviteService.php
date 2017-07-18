<?php

namespace App\Services;

use App\User;
use App\GroupInvite;

class InviteService
{

    protected $confirmedEmail;

    protected $alreadyUsedEmails;

    public $request;

    protected $team_id;

    public function invite($request, $team_id, $list = false)
    {
        $this->request = $request;
        $this->$team_id = $$team_id;
        if ($this->validateUniqueInArrayOrList($list)) {

        }
    }

    public function validateUniqueInArrayOrList($list = false)
    {
        if ($list) {
            $getEmails = explode(',', $this->request->emails);
            for ($i = 0; $i <= count($getEmails); $i++) {
                if ($this->validate($getEmails[$i])) {
                    
                    $this->confirmedEmail = $getEmails[$i] .', ';
                } else {

                }
            }
        } else {
            for ($i = 0; $i < count($this->request->email); $i++) {
                if (! is_null($this->request->email[$i])) {
                    if ($this->validate($email[$i])) {
                        return $this->confirmPreviousInviteByEmail($this->request->email[$i]);
                    }
                }  else {
                    return $this->confirmPreviousInviteByPhone($this->request->phone[$i]);
                }
            }
        }
    }

    public function confirmPreviousInviteByEmail($email)
    {
        $previousInvite = GroupInvite::where('email', $email)->first();
        if ($previousInvite) {
            return $this->analyzeResponse($previousInvite);
        }
        return false;
    }

    public function confirmPreviousInviteByPhone($phone)
    {
        $previousInvite = GroupInvite::where('phone', $phone)->first();
        if ($previousInvite) {
            return $this->analyzeResponse($previousInvite);
        }
        return false;
    }

    public function analyzeResponse()
    {
        if ($previousInvite->status == 'waiting') {
            return 'Previous Invitation is awaiting Acceptance';
        } elseif ($previousInvite->status == 'accepted') {
            return 'User already joined the team';
        } elseif ($previousInvite->status == 'declined') {
            return 'User has declined the Invitation';
        }
    }

    public function currentUser($email)
    {
        return $currentUser = User::where('email', $email)
            ->wherePivot('group_id', $this->team_id)
            ->first() ? 'User is already a member' : false;
    }

    public function validate($email)
    {
        return $valid = filter_var($email, FILTER_VALIDATE_EMAIL)
            ? true : false;
    }

    public function generateInviteLink($emailOrPhone, $team_id)
    {
        return $this->request->root() . '/team/'. $team_id .'/invite/' . encrypt($emailOrPhone);
    }

}
