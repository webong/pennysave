<?php

namespace App\Services;

use App\Group as Team;
use App\Services\RoleService;
use App\UserGroup;
use Auth;

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
        $team_status = $this->handleStatus($request);

        $uuid = gen_uuid();
        $this->team->id = $uuid;
        $this->team->name = ucwords($request->name);
        $this->team->amount = $request->amount;
        $this->team->participants = $request->participants;
        $this->team->recurrence = $request->recurrence;
        $this->team->start_date = $request->start_date;
        $this->team->status = $team_status;
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

    public function getTeam($team_id)
    {
        return $this->team->where('id', $team_id)->first();
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

}
