<?php

namespace App\Services;

use App\Group as Team;
use App\Services\RoleService;
use App\User;
use App\UserGroup;
use Auth;
use Carbon\Carbon;
use DB;

class TeamService
{
    protected $roleService;

    public function __construct(RoleService $roleService, UserGroup $userGroup, Team $team)
    {
        $this->team = $team;
        $this->roleService = $roleService;
        $this->userGroup = $userGroup;
    }

    public function create($request) {
        $uuid = gen_uuid();
        $this->team->id = $uuid;
        $this->team->name = ucwords($request->name);
        $this->team->amount = $request->amount;
        $this->team->recurrence = $request->recurrence;
        $this->team->start_date = $request->start_date;
        $this->team->status = $this->handleStatus($request);
        if ($this->team->save()) {
            $getRole = $this->roleService->getRole('group_admin');
            $userRole = ($getRole) ? $getRole->id : 3;
            $this->userGroup::create([
                'user_id' => Auth::user()->id,
                'group_id' => $uuid,
                'role_id' => $userRole,
                'status' => 'active',
            ]);
            return $uuid;
        }
        return false;
    }

    public function handleStatus($request)
    {
        if ($request->auto_start_date) {
            // Create Auto-Start Job

            return 'auto';
        }
        return 'inactive';
    }

    public function getTeamOnly($team_id)
    {
        return Team::findOrFail($team_id);
    }

    public function getTeam($team_id)
    {
        return $this->team->where('id', $team_id)
            ->with('role.group', 'contribution_order.user', 'debit_records')
            ->first();
    }
    
    public function registerMemberToTeam($user_id, $team_id)
    {
        $userRole = 3;
        return $this->userGroup::Create([
            'user_id' => $user_id,
            'group_id' => $team_id,
            'role_id' => $userRole,
            'status' => 'active',
        ]);
    }

    public function updateStartSchedule($team_id, $request)
    {
        return $team = Team::where('id', $team_id)
            ->update(['start_date' => $request->update_date]);
    }

    public function startNow($team_id)
    {
        $team = $this->getTeamOnly($team_id);
        $setArrangment = $this->contributionOrder($team_id);
        $order = $this->saveContributionOrder($setArrangment, $team);


        if (Team::where('id', $team_id)
            ->update([
                'status' => 'active',
                'start_date' => Carbon::now(),
        ])) {
            $team = $this->getTeamOnly($team_id);
            $setArrangment = $this->contributionOrder($team_id);
            $order = $this->saveContributionOrder($setArrangment, $team);
            return $order;
        }
    }

    public function contributionOrder($team_id)
    {
        $members = $this->getAllTeamMembers($team_id);
        foreach ($members as $member) {
            $arrange[] = $member->id;
        }
        shuffle($arrange);
        return $arrange;
    }

    public function getAllTeamMembers($team_id)
    {
        return User::whereHas('group', function($query) use ($team_id) {
            $query->where('id', $team_id);
        })->get();
    }

    public function saveContributionOrder($arranged, $team)
    {
        $id = $team->id;
        $current_cycle = $team->completed_cycle + 1;
        $start_date = $team->start_date->toDateString();
        $recurrence = $team->recurrence;
        foreach($arranged as $key => $value) {
            $position = $key + 1;
            $date = new Carbon($start_date);
            $get_date[] = $position;
            $get_date[] = schedule_date($date, 4, $position);
            $list[] = [
                'order' => $position, 'team_id' => $id, 
                'user_id' => $value, 'current_cycle' => $current_cycle,
                'schedule_date' => schedule_date($date, 1, $position),
                'status' => false,
            ];
        }
        DB::table('group_contribution_orders')->insert($list);
        return $list;
    }
}
