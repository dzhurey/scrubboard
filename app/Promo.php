<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
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
        'code'
    ];
}
