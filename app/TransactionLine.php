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
        'discount',
        'discount_amount',
        'amount',
        'bor',
        'note',
        'brand_id',
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

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }
}
