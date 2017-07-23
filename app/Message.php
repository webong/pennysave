<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'subject', 'brief_content', 'content', 'attachments',
    ];

    public $timestamps = false;

    public function message_ref()
    {
        return $this->hasMany('\App\MessageRef');
    }
}
