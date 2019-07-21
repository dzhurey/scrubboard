<?php

namespace App;

use App\BaseModel;

class ItemSubCategory extends BaseModel
{
    protected $fillable = [
        'name',
        'item_group_id',
    ];

    protected $searchable = [
        'name',
        'itemGroup__name',
    ];

    public function itemGroup()
    {
        return $this->belongsTo('App\ItemGroup');
    }

    public function items()
    {
        return $this->hasMany('App\Item');
    }
}
