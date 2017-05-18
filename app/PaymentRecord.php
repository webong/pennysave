<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentRecord extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'amount', 'group_id',
    ];

    public function user()
    {
        return $this->belongsTo('\App\User');
    }
}
