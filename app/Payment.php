<?php

namespace App;

use App\BaseModel;

class Payment extends BaseModel
{
    protected $fillable = [
        'customer_id',
        'payment_date',
        'note',
        'total_amount'
    ];

    protected $searchable = [
        'customer__name'
    ];

    public function paymentLines()
    {
        return $this->hasMany('App\PaymentLine', 'payment_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
