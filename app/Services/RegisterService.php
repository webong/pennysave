<?php

namespace App\Services;

use App\User;
use App\Profile;
use App\Role;

class RegisterService
{

    public static function register($request)
    {
        $email = (isset($request['email']) && !$request['email'] == '') ? $request['email'] : NULL;
        $phone = (isset($request['phone']) && !$request['phone'] == '') ? $request['phone'] : NULL;

        $user = User::create([
            'id' => gen_uuid(),
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $email,
            'phone' => $phone,
            'password' => bcrypt($request['password']),
        ]);

        return $user;
    }
}
