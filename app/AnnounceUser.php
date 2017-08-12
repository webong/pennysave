<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnnounceUser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'announce_id', 'team_id', 'user_id', 'status'
    ];

    public $incrementing = false;

    protected $table = 'announce_users';

    public function announce()
	{
		return $this->belongsTo('\App\Announcement', 'announce_id');
	}

    public function team()
	{
		return $this->belongsTo('\App\Group', 'team_id', 'id');
	}

    public function user()
	{
		return $this->belongsTo('\App\User', 'user_id', 'id');
	}


}
