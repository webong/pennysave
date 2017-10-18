<?php

namespace App\Services;

use App\Services\RoleService;
use App\Group as Team;
use App\UserGroup;
use Carbon\Carbon;
use App\User;
use Auth;
use DB;

class TeamService
{
    protected $team;
    protected $user;
    protected $userGroup;
    protected $roleService;

    public function __construct(RoleService $roleService, UserGroup $userGroup, User $user, Team $team)
    {
        $this->team = $team;
        $this->roleService = $roleService;
        $this->userGroup = $userGroup;
        $this->user = $user;
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
            ->with('role.group', 'contribution_order.user',
            'debit_records', 'credit_account', 'debit_account')
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
        $checkTeam = $this->confirmMembers($team_id);
        if ($checkTeam == 'success') {
            if (Team::where('id', $team_id)
                ->update([
                    'status' => 'active',
                    'start_date' => Carbon::now(),
            ])) {
                $team = $this->getTeamOnly($team_id);
                $setArrangment = $this->contributionOrder($team_id);
                $order = $this->saveContributionOrder($setArrangment, $team);
                return 'success';
            }
        } else {
            return $checkTeam;
        }
    }

    public function confirmMembers($team_id)
    {
        $team = $this->teamWithMembers($team_id);
        if ($team->user->count() > 1) {
            $members = $this->user::whereHas('group', function ($query) use($team) {
                $query->where('group_id', $team->id)
                ->where('cycle', $team->completed_cycle + 1)
                ->where('debiting', null);
            })->get();
            foreach ($members as $member) {
                if (is_null($member->crediting) || is_null($member->debiting)) {
                    $accountsNotSet[] = $member->full_name();
                }
            }
            if (! isset($accountsNotSet)) {
                return 'success';
            }
            return json_encode($accountsNotSet);
        }
        return 'error';
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

    public function countTeamMembers($team_id)
    {
        return User::whereHas('group', function($query) use ($team_id) {
            $query->where('id', $team_id);
        })->count();
    }

    public function teamWithMembers($team_id)
    {
        return Team::find($team_id)->with('user')->first();
    }

    public function saveContributionOrder($arranged, $team)
    {
        $id = $team->id;
        $current_cycle = $team->completed_cycle + 1;
        $start_date = $team->start_date->toDateString();
        $recurrence = $team->recurrence;
        foreach($arranged as $key => $value) {
            $position = $key + 1;
            $date = schedule_date(new Carbon($start_date), $recurrence, $position);
            $dates[] = $date;
            $list[] = [
                'order' => $position, 'team_id' => $id, 
                'user_id' => $value, 'current_cycle' => $current_cycle,
                'schedule_date' => $date,
                'status' => false,
            ];
        }
        DB::table('group_contribution_orders')->insert($list);
        return $list;
    }
}
