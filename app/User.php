<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'first_name', 'last_name', 'email', 'phone', 'password', 'avatar',
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

    public function full_name()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function role()
    {
        return $this->belongsToMany('\App\Role', 'group_user')
            ->withPivot(['group_id', 'role_id', 'status'])->withTimestamps();
    }

	public function group()
	{
		return $this->belongsToMany('\App\Group', 'group_user')
            ->withPivot(['role_id', 'group_id', 'status'])->withTimestamps();
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

    public function savings_records()
    {
        return $this->hasMany('\App\SavingsRecord');
    }

    public function user_wallet()
    {
        return $this->hasMany('\App\UserWallet');
    }

    public function user_withdrawals()
    {
        return $this->hasMany('\App\UserWithdrawal');
    }

    public function message()
    {
        return $this->hasMany('\App\Message');
    }

    public function group_invite()
    {
        return $this->hasMany('\App\GroupInvite'. 'inviter_id', 'id');
    }

    public function announce_user()
    {
        return $this->hasMany('\App\AnnounceUser', 'user_id', 'id');
    }
}
