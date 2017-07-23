<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavingsRecord extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'savings_plan_id', 'amount',
    ];

    protected $table = 'savings_records';

    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function personal_save()
    {
        return $this->belongsTo('\App\PersonalSave');
    }
}
