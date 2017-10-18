<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'cycle', 'group_id', 'debiting',
        'crediting', 'role_id', 'status',
    ];

    protected $table = 'group_user';

    protected $dates = ['created_at', 'updated_at'];

}
