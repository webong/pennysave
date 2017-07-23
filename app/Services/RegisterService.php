<?php

namespace App\Services;

use App\User;
use App\Profile;
use App\Role;
use App\Services\TeamService;

class RegisterService
{
    protected $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    public function register($request)
    {
        $user_id = gen_uuid();
        $email = (isset($request['email']) && !$request['email'] == '') ? $request['email'] : NULL;
        $phone = (isset($request['phone']) && !$request['phone'] == '') ? $request['phone'] : NULL;

        $user = User::create([
            'id' => $user_id,
            'first_name' => ucwords($request['first_name']),
            'last_name' => ucwords($request['last_name']),
            'email' => $email,
            'phone' => $phone,
            'password' => bcrypt($request['password']),
        ]);

        if (isset($request['registerToTeam'])) {
            $this->teamService->registerMemberToTeam($user_id, $request['registerToTeam']);
        }

        return $user;
    }
}
