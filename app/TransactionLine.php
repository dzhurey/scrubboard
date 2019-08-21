<?php

namespace App;

use App\BaseModel;

class TransactionLine extends BaseModel
{
    protected $fillable = [
        'transaction_id',
        'item_id',
        'quantity',
        'unit_price',
        'amount',
        'note',
    ];

    protected $searchable = [];

    public function transaction()
    {
        return $this->belongsTo('App\Transaction');
    }

    public function item()
    {
        return $this->belongsTo('App\Item');
    }
}
