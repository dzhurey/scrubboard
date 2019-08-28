<?php

namespace App;

use App\BaseModel;

class PaymentLine extends BaseModel
{
    protected $fillable = [
        'payment_id',
        'transaction_id',
        'amount'
    ];

    protected $searchable = [];

    public function payment()
    {
        return $this->belongsTo('App\Payment');
    }

    public function transaction()
    {
        return $this->belongsTo('App\Transaction');
    }
}
