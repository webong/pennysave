<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recurrence;
use App\Http\Requests\TeamRequest;
use App\Http\Requests\InviteSinglyRequest;
use App\Http\Requests\InviteListRequest;
use App\Services\TeamService;
use App\Services\InviteService;
use Auth;
use App\GroupInvite;
use App\User;

class TeamController extends Controller
{

    protected $teamService;

    protected $inviteService;

    public function __construct(TeamService $teamService, InviteService $inviteService)
    {
        $this->teamService = $teamService;
        $this->inviteService = $inviteService;
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
            return view('team.team', $data);
        }
    }

    public function invite(InviteSinglyRequest $request, $team_id)
    {
        if ($sendInvitesResponse = $this->inviteService->invite($request, $team_id, Auth::user())) {
            return redirect()->back()->with('message', $sendInvitesResponse);
        }
        return redirect()->back()->with('error', 'Error Sending Invitations');
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
}
