<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageAttachment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'message_id', 'given_name', 'file_name_on_disk', 'size',
    ];

}
