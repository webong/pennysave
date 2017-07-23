<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class GroupInvite extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'email', 'phone', 'inviter_id', 'team_id', 'status',
    ];

    protected $table = 'group_invites';

    public function group()
    {
        return $this->belongsTo('\App\Group', 'team_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('\App\User', 'inviter_id');
    }

    public function invited()
    {
        return $this->belongsTo('\App\User', 'email', 'email')
            ->where('email', Auth::user()->email)
            ->orWhere('phone', Auth::user()->phone);
    }

}
