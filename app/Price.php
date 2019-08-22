<?php

namespace App;

use App\BaseModel;

class Price extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    protected $searchable = [
        'name',
    ];

    public function priceLines()
    {
        return $this->hasMany('App\PriceLine');
    }

    public function customers()
    {
        return $this->hasMany('App\Customer');
    }
}
