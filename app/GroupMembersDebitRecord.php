<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMembersDebitRecord extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'team_id', 'cycle', 'status',
    ];

    public $incrementing = false;

    protected $table = 'group_members_debit_records';

    public function user()
  	{
  		return $this->belongsToMany('\App\User');
  	}

    public function team()
	{
		return $this->belongsTo('\App\Group', 'team_id', 'id');
	}

}
