<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Services\RegisterService;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ApiRegisterController
{

    public function register(RegisterRequest $request)
    {
        if (RegisterService::register($request)) {
            return $this->sendRegisterResponse();
        }
        return $this->errorMessage();
    }

    public function sendRegisterResponse()
    {
        $message = [
            'type' => 'success',
            'message' => 'Registration Successful',
            'data' => [
                'token' => $this->token(),
            ],
        ];
        return response()->json($message);
    }

    public function errorMessage()
    {
        return $message = [
            'type' => 'error',
            'message' => 'Registration Failed',
        ];
        response()->json($message);
    }

    public function token()
    {
        return JWTAuth::fromUser(Auth::user());
    }
}
