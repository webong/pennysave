<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name', 'logo',
    ];

    protected $table = 'banks';

    public function payment()
    {
        return $this->hasMany('\App\PaymentDetail');
    }
}
