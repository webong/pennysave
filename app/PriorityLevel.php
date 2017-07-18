<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriorityLevel extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'priority_level',
    ];

    protected $table = 'priority_levels';

    public function personal_save()
    {
        return $this->hasOne('\App\PersonalSave');
    }
}
