<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

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
  		return $this->belongsToMany('\App\User', 'group_user')
            ->withPivot(['user_id', 'cycle', 'role_id', 'debiting', 'crediting', 'status'])
            ->withTimestamps();
    }

    public function credit_account()
  	{
  		return $this->belongsToMany('\App\Account', 'group_user', 'group_id', 'crediting')
            ->withPivot(['user_id', 'cycle', 'role_id', 'debiting', 'crediting', 'status'])
            ->wherePivot('user_id', Auth::user()->id)
            ->withTimestamps();
    }

    public function debit_account()
  	{
  		return $this->belongsToMany('\App\Account', 'group_user', 'group_id', 'debiting')
            ->withPivot(['user_id', 'cycle', 'role_id', 'debiting', 'crediting', 'status'])
            ->wherePivot('user_id', Auth::user()->id)
            ->withTimestamps();
    }

    public function contribution()
    {
        return $this->hasMany('\App\Contribution');
    }

    public function contribution_order()
    {
        return $this->hasMany('\App\GroupContributionOrder', 'team_id');
    }

    public function role()
    {
        return $this->belongsToMany('\App\Role', 'group_user')
            ->withPivot(['user_id', 'cycle', 'role_id', 'debiting', 'crediting', 'status'])
            ->withTimestamps();
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

    public function debit_records()
    {
        return $this->hasMany('\App\GroupMembersDebitRecord', 'team_id');
    }
}
