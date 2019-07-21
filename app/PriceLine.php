<?php

namespace App;

use App\BaseModel;

class PriceLine extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_id',
        'price_id',
        'amount',
    ];

    public function price()
    {
        return $this->belongsTo('App\Price');
    }

    public function item()
    {
        return $this->belongsTo('App\Item');
    }
}
