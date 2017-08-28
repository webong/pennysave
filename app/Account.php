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
        'id', 'user_id', 'account_type', 'type', 'type_details',
        'last_four_digits', 'authorization_token', 'status'
    ];

    public $incrementing = false;

    protected $table = 'accounts';

    public function user()
	{
		return $this->belongsTo('\App\User');
	}
}
