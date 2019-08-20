<?php

namespace App;

use App\BaseModel;

class Agent extends BaseModel
{
    protected $fillable = [
        'transaction_type',
        'transaction_status',
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
