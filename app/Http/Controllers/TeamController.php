<?php

namespace App\Http\Controllers;

use App\Http\Requests\SavePaymentAccountRequest;
use Propaganistas\LaravelIntl\Facades\Country;
use App\Http\Requests\InviteSinglyRequest;
use App\Http\Requests\InviteListRequest;
use App\Services\AnnouncementService;
use Illuminate\Support\HtmlString;
use App\Http\Requests\TeamRequest;
use App\Services\MessageService;
use App\Services\AccountService;
use App\Services\PaymentService;
use App\Services\InviteService;
use App\Services\TeamService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\GroupInvite;
use App\Recurrence;
use Carbon\Carbon;
use App\User;
use App\Bank;
use Auth;

class TeamController extends Controller
{
    protected $teamService;
    protected $inviteService;
    protected $announcementService;
    protected $messageService;
    protected $accountService;
    protected $paymentService;

    public function __construct(
        TeamService $teamService,
        InviteService $inviteService,
        AnnouncementService $announcementService,
        MessageService $messageService,
        AccountService $accountService,
        PaymentService $paymentService
    )
    {
        $this->teamService = $teamService;
        $this->inviteService = $inviteService;
        $this->announcementService = $announcementService;
        $this->messageService = $messageService;
        $this->accountService = $accountService;
        $this->paymentService = $paymentService;
    }

    public function team()
    {
        $data['recurrence'] = Recurrence::all();
        return view('team.create-team', $data);
    }

    public function create(TeamRequest $request)
    {
        if ($teamCreated = $this->teamService->create($request)) {
            return redirect('/teams/' . $teamCreated)->with('message', 'Team Created Successfully');
        }
        return redirect()->back()->with('error', 'Error Creating Team');
    }

    public function index($team_id)
    {
        if ($data['team'] = $this->teamService->getTeam($team_id)) {
            $data['notifications'] = $this->announcementService->getUnreadTeamAnnouncements($team_id);
            $data['unread_messages'] = $this->messageService->getNewMessages($team_id);
            $data['countries'] = Country::all();
            $data['banks'] = Bank::all();
            $data['card_account'] = $this->accountService->card_account();
            $data['bank_account'] = $this->accountService->bank_account();
            $metadata = ['custom_fields' => ['team' => $team_id]];
            $data['metadata'] = $metadata;
            $data['payment_account'] = ($data['team']->debit_account->count() && $data['team']->credit_account->count())
            ? true : false;
            return view('team.team', $data);
        }
    }

    public function invite(InviteSinglyRequest $request, $team_id)
    {
        $sendInvitesResponse = $this->inviteService->invite($request, $team_id, Auth::user());
        if ($sendInvitesResponse) {
            // return redirect()->back()->with('message', new HtmlString($sendInvitesResponse));
            return redirect()->back()->with('message', $sendInvitesResponse);
        } else {
            if (is_bool($sendInvitesResponse)) {
                return redirect()->back()->with('error', 'Error Sending Invitations');
            } else {
                return redirect()->back()->with('error', 'No Emails or Phone Numbers indicated');
            }
        }
    }

    public function view_invites()
    {
        if ($data['allInvites'] = $this->inviteService->getAllInvites()) {
            $data['notifications'] = $this->announcementService->getAllUnreadAnnouncements();
            return view('team.view-invites', $data);
        } else {
            return redirect()->back()->with('error', 'Error Retrieving Invites');
        }
    }

    public function invites_response(Request $request)
    {
        if ($response = $this->inviteService->inviteResponse($request)) {
            if ($response == 'accepted'): return redirect('/dashboard')->with('message', 'Invitation Accepted');
            elseif ($response == 'declined'): return redirect('/dashboard')->with('info', 'Invitation Declined');
            else: return redirect()->back()->with('error', 'Error Processing Invitation');
            endif;
        }
    }

    public function invite_in_list(InviteListRequest $request, $team_id)
    {
        if ($sendInvites = $this->inviteService->invite($request, $team_id, Auth::user(), $list = true)) {
            return redirect()->back()->with('message', 'Invitations Sent Successfully');
        }
        return redirect()->back()->with('error', 'Error Sending Invitations');
    }

    public function invite_register($team_id, $invite_token)
    {
        $data['team_id'] = $team_id;
        $confirmInvite = $this->inviteService->inviteRegister($team_id, $invite_token);
        if (is_array($confirmInvite)) {
            $data = array_merge($data, $confirmInvite);
            return view('auth.register', $data);
        } elseif ($confirmInvite == 'invalid') {
            return redirect('/register')->with('info', 'The Invitation Link Is Invalid');
        } elseif ($confirmInvite == 'expired') {
            return redirect('/register')->with('info', 'The Invitation has expired');
        } else {
            $data['emailOrPhone'] = $confirmInvite;
            session()->put('url.intended', url('/teams/invites'));
            return view('auth.login', $data);
        }
    }

    public function update_schedule($team_id, Request $request)
    {
        $this->validate($request, [
            'update_date' => 'required|date|after:yesterday',
        ]);
        if ($this->teamService->updateStartSchedule($team_id, $request)) {
            $date = Carbon::createFromFormat('Y-m-d', $request->update_date);
            $response['formatted'] = $date->format('l jS F, Y');
            $response['readable'] = '(' . $date->diffForHumans() . ')';
            echo json_encode($response);
            exit();
        } else {
            echo 'error';
        }
    }

    public function start_now($team_id)
    {
        $startStatus = $this->teamService->startNow($team_id);
        if ($startStatus == 'success') {
            $started_path = '/teams/' . $team_id . '/started';
            echo $started_path;
            exit();
        } else {
            echo $startStatus;
            exit();
        }
    }

    public function started_redirect()
    {
        return redirect()->back()->with('message', 'Etibe Started Successfully');
    }

    public function set_payment_now(SavePaymentAccountRequest $request, $team_id)
    {
        if ($this->paymentService->addPaymentAccount($request, $team_id)) {
            echo 'success';
            exit();
        }
        echo 'failed';
        exit();
    }
}
