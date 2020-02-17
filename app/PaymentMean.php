<?php

namespace App;

use App\BaseModel;

class PaymentMean extends BaseModel
{
    const PAYMENT_METHODS = [
        'cash' => 'Cash',
        'bank_transfer' => 'Bank Transfer',
        'credit_card' => 'Credit Card',
        'other' => 'Other',
        'bebemoney' => 'Bebemoney'
    ];

    const PAYMENT_TYPES = [
        'down_payment' => 'Down Payment',
        'acquittance' => 'Pelunasan',
    ];

    protected $fillable = [
        'payment_id',
        'bank_account_id',
        'bank_id',
        'payment_method',
        'amount',
        'payment_date',
        'note',
        'payment_type',
        'receiver_name',
        'credit_card_no',
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
