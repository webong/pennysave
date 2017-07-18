<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recurrence;
use App\Http\Requests\TeamRequest;
use App\Http\Requests\InviteSinglyRequest;
use App\Services\TeamService;
use App\Services\InviteService;

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
        if ($sendInvites = $this->inviteService->invite($request, $team_id)) {
            return redirect()->back()->with('message', 'Invitations Sent Successfully');
        }
        return redirect()->back()->with('error', 'Error Sending Invitations');
    }

    public function inviteInList(InviteListRequest $request, $team_id)
    {
        if ($sendInvites = $this->inviteService->invite($request, $team_id, $list = true)) {
            return redirect()->back()->with('message', 'Invitations Sent Successfully');
        }
        return redirect()->back()->with('error', 'Error Sending Invitations');
    }
}
