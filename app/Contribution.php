<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'amount', 'group_id', 'status',
    ];

    protected $table = 'contributions';

    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function group()
    {
        return $this->belongsTo('\App\Group');
    }
}
