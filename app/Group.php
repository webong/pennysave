<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Group extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'amount', 'duration', 'start_date',
    ];

    public function user()
	{
		return $this->hasMany('User');
	}

    public function contribution()
    {
        return $this->hasMany('\App\Contribution');
    }
}
