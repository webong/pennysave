<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupWithdrawalRecord extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'amount', 'group_id',
    ];

    protected $table = 'group_withdrawal_records';

    public function user()
    {
        return $this->belongsTo('\App\User');
    }
}
