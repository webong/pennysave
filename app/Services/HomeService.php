<?php

namespace App\Services;

use App\Group;
use App\User;
use Auth;

class HomeService
{

    public function home()
    {
        return User::with(['group', 'personal_save'])
            ->where('id', Auth::user()->id)->first();
    }

}
