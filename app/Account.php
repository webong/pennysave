<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Account extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'token', 'four_digits', 'status'
    ];

    public function user()
	{
		return $this->belongsTo('User');
	}
}
