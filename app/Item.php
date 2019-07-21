<?php

namespace App;

use App\BaseModel;

class Item extends BaseModel
{
    const ITEM_TYPES = [
        'service' => 'Service',
        'item' => 'Item',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_type',
        'description',
        'product',
        'service',
        'price',
        'item_sub_category_id',
    ];

    protected $searchable = [
        'description',
        'product',
        'service',
        'itemSubCategory__name'
    ];

    public function itemSubCategory()
    {
        return $this->belongsTo('App\ItemSubCategory');
    }

    public function priceLines()
    {
        return $this->hasMany('App\PriceLine');
    }
}
