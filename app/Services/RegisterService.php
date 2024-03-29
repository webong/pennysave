<?php

namespace App\Services;

use App\User;
use App\Role;
use App\Profile;
use App\Services\TeamService;
use App\Services\InviteService;
use Propaganistas\LaravelIntl\Facades\Country;

class RegisterService
{
    protected $teamService;
    protected $inviteService;

    public function __construct(TeamService $teamService, InviteService $inviteService)
    {
        $this->teamService = $teamService;
        $this->inviteService = $inviteService;
    }

    public function index()
    {
        return Country::all();
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
            $this->inviteService->updateInviteStatusOnRegister('accepted', $request['registerToTeam'], $request);
        }

        return $user;
    }
}
