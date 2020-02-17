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
        'code',
        'quota',
        'percentage',
        'max_promo',
        'start_promo',
        'end_promo',
        'type'
    ];

    protected $searchable = [
        'name',
    ];

    public function salesOrders()
    {
        return $this->hasMany('App\SalesOrder');
    }

    public function transactionLines()
    {
        return $this->hasMany('App\TransactionLine');
    }
}
