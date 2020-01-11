<?php

namespace App;

use App\BaseModel;

class Promo extends BaseModel
{
    const PROMO_TYPES = [
        'promo' => 'Promo',
        'bebemoney' => 'Bebe Money',
    ];

    protected $fillable = [
        'name',
        'percentage',
        'max_promo',
        'start_promo',
        'end_promo',
        'type'
    ];

    protected $searchable = [
        'name',
    ];

    public function salesOrder()
    {
        return $this->hasMany('App\SalesOrder');
    }
}
