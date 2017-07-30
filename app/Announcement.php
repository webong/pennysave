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
        'id', 'team_id', 'subject', 'content'
    ];

    public $incrementing = false;

    protected $table = 'announcements';

    public function team()
	{
		return $this->belongsTo('\App\Group', 'team_id');
	}
}