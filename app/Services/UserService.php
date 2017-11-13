<?php

namespace App\Services;

use Carbon\Carbon;
use App\User;
use App\Role;
use Auth;
use DB;

class UserService
{

    public function __construct()
    {
        $this->startOfWeek = Carbon::now()->startOfWeek();
        $this->startOfMonth = Carbon::now()->startOfMonth();
    }

    public function allUsers()
    {
        $users['admins'] = $this->adminUsers();
        $users['users'] = $this->users();
        $users['count1'] = 0;
        $users['count2'] = 0;
        return $users;
    }

    public function adminUsers()
    {
        return User::with(array('roles' => function ($query)
        {
            $query->whereIn('name', ['owner', 'super_admin', 'admin']);
        }
        ))->select('users.*')->get();
    }

    public function users()
    {
        return User::with(array('roles' => function ($query)
        {
            $query->where('name', 'user');
        }
        ))->select('users.*')->get();
    }

    public function getFirstName($emailOrPhone) {
        $user =  User::where('email', $emailOrPhone)
            ->orWhere('phone', $emailOrPhone)->first();
        if ($user) return $user->first_name;
    }

    public function getUsersIDAndName($team_id)
    {
        return $data['users'] = DB::table('users')
            ->join('group_user', 'users.id', '=', 'group_user.user_id')
            ->join('groups', 'groups.id', '=', 'group_user.group_id')
            ->where('groups.id', $team_id)
            ->select('users.id', DB::raw('concat(users.first_name," ", users.last_name) as name'))
            ->get();
    }

    public function getNamebyId($user_id)
    {
        return User::find($user_id)->full_name();
    }

    public function confirmEmailPresent()
    {
        if (! Auth::user()->email == '') {
            return false;
        }
        return true;
    }
}
