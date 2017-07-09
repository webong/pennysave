<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'phone', 'password', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	public $incrementing = false;

	public function group()
	{
		return $this->belongsToMany('\App\Group');
	}

	public function payment()
	{
		return $this->hasMany('\App\Payment');
	}

    public function account()
    {
        return $this->hasMany('\App\Account');
    }

    public function contribution()
    {
        return $this->hasMany('\App\Contribution');
    }

    public function payment_record()
    {
        return $this->hasMany('\App\PaymentRecord');
    }

    public function personal_save()
    {
        return $this->hasMany('\App\PersonalSave');
    }

}
