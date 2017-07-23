<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recurrence extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'period',
    ];

    protected $table = 'recurrences';

    public function personal_save()
    {
        return $this->hasMany('\App\PersonalSave', 'recurrence');
    }

    public function group()
    {
        return $this->hasMany('\App\Group', 'recurrence');
    }
}
