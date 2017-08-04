<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $fillable = [
        'name', 'display_name', 'description',
    ];

    protected $table = 'roles';

    public function user()
    {
        return $this->belongsToMany('\App\User', 'group_user')
            ->withPivot(['user_id', 'group_id', 'status'])->withTimestamps();
    }

    public function group()
    {
        return $this->belongsToMany('\App\Group', 'group_user')
            ->withPivot(['user_id', 'group_id', 'status'])->withTimestamps();
    }

}
