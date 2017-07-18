<?php

namespace App\Services;

use App\User;
use App\Role;
use DB;
use Carbon\Carbon;

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

    public function newRegistrations()
    {

    }
}
