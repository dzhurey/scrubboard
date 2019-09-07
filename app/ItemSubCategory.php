<?php

namespace App;

use App\BaseModel;

class ItemSubCategory extends BaseModel
{
    protected $fillable = [
        'name','code'
    ];

    protected $searchable = [
        'name',
    ];

    public function items()
    {
        return $this->hasMany('App\Item');
    }
}
