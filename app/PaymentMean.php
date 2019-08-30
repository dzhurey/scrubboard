<?php

namespace App;

use App\BaseModel;

class PaymentMean extends BaseModel
{
    const PAYMENT_TYPES = [
        'cash' => 'Cash',
        'bank_transfer' => 'Bank Transfer',
        'credit_card' => 'Credit Card',
        'other' => 'Other',
    ];

    protected $fillable = [
        'payment_id',
        'bank_account_id',
        'bank_id',
        'payment_type',
        'amount',
        'payment_date',
        'note'
    ];

    protected $searchable = [];

    public function payment()
    {
        return $this->belongsTo('App\Payment');
    }

    public function bankAccount()
    {
        return $this->belongsTo('App\BankAccount');
    }
}
