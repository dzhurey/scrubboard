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
        'price',
        'item_group_id',
        'item_sub_category_id',
    ];

    protected $searchable = [
        'description',
        'product',
        'service',
        'itemGroup__name',
        'itemSubCategory__name',
    ];

    public function itemGroup()
    {
        return $this->belongsTo('App\ItemGroup');
    }

    public function itemSubCategory()
    {
        return $this->belongsTo('App\ItemSubCategory');
    }

    public function priceLines()
    {
        return $this->hasMany('App\PriceLine');
    }

    public function transactionLines()
    {
        return $this->hasMany('App\TransactionLine');
    }
}
