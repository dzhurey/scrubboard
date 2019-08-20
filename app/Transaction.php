<?php

namespace App;

use App\BaseModel;

class Transaction extends BaseModel
{
    protected $table = 'transactions';

    const TRANSACTION_TYPES = [
        'order' => 'Sales Order',
        'invoice' => 'Sales Invoice',
    ];

    const ORDER_TYPES = [
        'general' => 'General',
        'endorser' => 'Endorser',
    ];

    protected $fillable = [
        'transaction_type',
        'transaction_status',
        'order_type',
        'customer_id',
        'transaction_date',
        'pickup_date',
        'delivery_date',
        'original_amount',
        'discount',
        'discount_amount',
        'freight',
        'total_amount',
        'note',
    ];

    protected $searchable = [
        'customer__name'
    ];

    public function transactionLines()
    {
        return $this->hasMany('App\TransactionLine');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
