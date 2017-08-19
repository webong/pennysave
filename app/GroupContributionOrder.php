<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupContributionOrder extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order', 'team_id', 'user_id', 'schedule_date', 'status'
    ];

    protected $dates = ['schedule_date'];
    
    protected $table = 'group_contribution_orders';

    public function user()
  	{
  		return $this->belongsTo('\App\User');
  	}

    public function team()
    {
        return $this->belongsTo('\App\Group', 'team_id');
    }
}
