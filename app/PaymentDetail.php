<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'account_name', 'account_no', 'bank_id',
    ];

    protected $table = 'user_payment_receipient_account';

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function bank()
    {
        return $this->belongsTo('\App\Bank');
    }
}
