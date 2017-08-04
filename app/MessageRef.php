<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageRef extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'message_id', 'team_id', 'sender', 'receiver', 'sender_status',
        'receiver_status',
    ];

    public function message()
    {
        return $this->belongsTo('\App\Message');
    }

    public function team()
    {
        return $this->belongsTo('\App\Group', 'team_id', 'id');
    }

    public function sender()
    {
        return $this->belongsTo('\App\User', 'sender', 'id');
    }

}
