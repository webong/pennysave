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
        'id', 'message_id', 'sender', 'receiver', 'sender_status',
        'receiver_status', 'sent_at',
    ];

    public function message()
    {
        return $this->belongsTo('\App\Message');
    }

    public function team()
    {
        return $this->belongsTo('\App\Group');
    }

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

}
