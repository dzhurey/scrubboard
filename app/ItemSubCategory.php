<?php

namespace App;

use App\BaseModel;

class ItemSubCategory extends BaseModel
{
    protected $fillable = [
        'name',
        'item_group_id',
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
