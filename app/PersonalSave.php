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
        'id', 'name', 'user_id', 'target_amount', 'instalment_amount',
        'recurrence', 'priority_level', 'target_date', 'start_date',
    ];

    protected $table = 'personal_saves';

    public $incrementing = false;

    protected $dates = ['target_date', 'start_date'];

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function save_record()
    {
        return $this->hasMany('\App\SavingsRecord', 'savings_plan_id', 'id');
    }

    public function recurrences()
    {
        return $this->belongsTo('\App\Recurrence', 'recurrence', 'id');
    }

    public function priority_level()
    {
        return $this->belongsTo('\App\PriorityLevel');
    }
}
