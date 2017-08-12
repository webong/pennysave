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
        'id', 'name', 'amount', 'duration', 'recurrence', 'start_date',
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

    public function message_ref()
    {
        return $this->hasMany('\App\MessageRef', 'team_id', 'id');
    }

    public function period()
    {
        return $this->belongsTo('\App\Recurrence', 'recurrence');
    }

    public function group_invite()
    {
        return $this->hasMany('\App\GroupInvite', 'team_id', 'id');
    }

    public function announce_user()
    {
        return $this->hasMany('\App\AnnounceUser', 'team_id', 'id');
    }

    public function announcement()
    {
        return $this->hasManyThrough('\App\Announcement', '\App\AnnounceUser', 'team_id', 'announce_id', 'id');
    }
}
