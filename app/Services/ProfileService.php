<?php

namespace App\Services;

use Auth;
use App\User;
use App\Traits\UploadTrait;

class ProfileService
{
    use UploadTrait;

    protected $uploadLocation = 'avatars';

    protected $avatarDimensions = [null, 300, 300];

    public function editProfile($request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $user->update([
                'name'      => $request->name,
                'username'  => $request->username,
                'email'     => $request->email,
            ]);
        return $user->profile()
            ->update([
                'gender'     => ($request->gender == 1) ? 'Male' : 'Female',
                'avatar'     => ($request->hasFile('avatar')) ?
                                urlencode($this->upload($this->uploadLocation, $request->file('avatar'), $this->avatarDimensions)) : $user->profile->avatar,
                'about'      => $request->about,
                'location'   => $request->location,
                'skills'     => $request->skills,
            ]);
    }

    public function userDetails()
    {
        return User::where('id', Auth::user()->id)
            ->join('profiles', 'profiles.user_id', 'users.id')
            ->first();
    }

}
