<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'cleared_balance', 'uncleared_balance', 'plan_attached_to',
    ];

    protected $table = 'user_wallets';

    public $incrementing = false;

    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('\App\User');
    }
}
