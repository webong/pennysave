<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserWithdrawal extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'withdrawal_sources', 'comments',
    ];

    protected $table = 'user_withdrawals';

    public $incrementing = false;

    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('\App\User');
    }
}
