<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'team_id', 'announcer', 'subject', 'content', 'status'
    ];

    public $incrementing = false;

    protected $table = 'announcements';

    public function team()
	{
		return $this->belongsTo('\App\Group', 'team_id');
	}

    public function user()
	{
		return $this->belongsTo('\App\User', 'announcer', 'id');
	}


}