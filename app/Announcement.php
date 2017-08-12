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
        'id', 'announcer', 'subject', 'content',
    ];

    public $incrementing = false;

    protected $table = 'announcements';

    public function announce_user()
	{
		return $this->hasMany('\App\AnnounceUser', 'announce_id', 'id');
	}

}