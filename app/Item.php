<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
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

    public function itemSubCategory()
    {
        return $this->belongsTo('App\ItemSubCategory');
    }
}
