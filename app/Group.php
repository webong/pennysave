<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'amount', 'duration', 'recurrence', 'start_date',
    ];

    public $incrementing = false;

    protected $table = 'groups';

    protected $dates = ['start_date'];

    public function user()
  	{
  		return $this->belongsToMany('\App\User', 'group_user')->withPivot(['user_id', 'role_id', 'status'])->withTimestamps();
  	}

    public function contribution()
    {
        return $this->hasMany('\App\Contribution');
    }

    public function role()
    {
        return $this->belongsToMany('\App\Role', 'group_user')->withPivot(['user_id', 'role_id', 'status'])->withTimestamps();
    }

}
