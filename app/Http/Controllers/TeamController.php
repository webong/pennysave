<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TeamRequest;
use App\Http\Requests\InviteSinglyRequest;
use Propaganistas\LaravelIntl\Facades\Country;
use App\Http\Requests\InviteListRequest;
use App\Services\AnnouncementService;
use Illuminate\Support\HtmlString;
use App\Services\MessageService;
use App\Services\InviteService;
use App\Services\TeamService;
use App\GroupInvite;
use App\Recurrence;
use App\User;
use Auth;

class TeamController extends Controller
{
    protected $teamService;
    protected $inviteService;
    protected $announcementService;
    protected $messageService;

    public function __construct(
        TeamService $teamService,
        InviteService $inviteService,
        AnnouncementService $announcementService,
        MessageService $messageService
    )
    {
        $this->teamService = $teamService;
        $this->inviteService = $inviteService;
        $this->announcementService = $announcementService;
        $this->messageService = $messageService;
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
            // dd($data['notifications']);
            return view('team.team', $data);
        }
    }

    public function invite(InviteSinglyRequest $request, $team_id)
    {
        $sendInvitesResponse = $this->inviteService->invite($request, $team_id, Auth::user());
        if ($sendInvitesResponse) {
            return redirect()->back()->with('message', new HtmlString($sendInvitesResponse));
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
            // dd($data['allInvites']);
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
            elseif ($response == 'rejected'): return redirect('/dashboard')->with('messsage', 'Invitation Rejected');
            else: return redirect()->back()->with('error', 'Error Processing Invitation');
            endif;
        }
    }

    public function inviteInList(InviteListRequest $request, $team_id)
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
            return view('auth.login', $data);
        }
    }

    public function update_schedule($team_id, Request $request)
    {
        $this->validate($request, [
            'update_date' => 'required|date|after:yesterday',
        ]);
        if ($this->teamService->updateStartSchedule($team_id, $request)) {
            echo 'updated';
        } else {
            echo 'error';
        }
    }

    public function start_now($team_id, Request $request)
    {
        if ($this->teamService->startNow($team_id, $request)) {
            return 'started';
        } else {
            return 'error';
        }
    }
}
