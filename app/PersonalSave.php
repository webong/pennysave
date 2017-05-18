<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalSave extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'target_amount', 'instalment_amount', 'target_date', 'recurrence',
    ];

    public function user()
    {
        return $this->belongsTo('\App\User');
    }
}
