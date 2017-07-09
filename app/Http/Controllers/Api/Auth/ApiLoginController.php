<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ApiLoginController
{

    public function login(LoginRequest $request)
    {
        return $this->attemptLogin($request);
    }

    public function attemptLogin($request)
    {
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($this->credentials($request))) {
                $errorType = 'invalid';
                return $this->errorMessage($errorType);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            $errorType = 'exception';
            return $this->errorMessage($errorType);
        }
        // all good so return the token
        return $this->sendLoginResponse();
    }

    public function sendLoginResponse()
    {
        $type = 'success';
        $message = 'Login Successful';
        return apiResMessage($type, $message, $this->token());
    }

    public function errorMessage($errorType)
    {
        if ($errorType == 'invalid') {
            $type = 'invalid_credentials';
            $message = 'Invalid Login Credentials';
            return apiResMessage($type, $message);
        } else {
            $type = 'token_error';
            $message = 'Error Creating Token';
            return apiResMessage($type, $message, NULL, 500);
        }
    }

    public function credentials($request)
    {
        return $request->only('email', 'password');
    }

    public function token()
    {
        return array('token' => JWTAuth::fromUser(Auth::user()));
    }
}
