<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'account_type', 'type_details',
        'last_four_digits', 'authorization_token', 'status'
    ];

    public $incrementing = false;

    protected $table = 'accounts';

    public function user()
	{
		return $this->belongsTo('\App\User');
	}

    public function debit_account()
  	{
  		return $this->belongsToMany('\App\Group', 'group_user')
            ->withPivot(['user_id', 'cycle', 'role_id', 'group_id', 'crediting', 'status'])
            ->withTimestamps();
    }

    public function credit_account()
  	{
  		return $this->belongsToMany('\App\Group', 'group_user', 'crediting', 'group_id')
            ->withPivot(['user_id', 'cycle', 'role_id', 'group_id', 'debiting', 'status'])
            ->withTimestamps();
    }

}
