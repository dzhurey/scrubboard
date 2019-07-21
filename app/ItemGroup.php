<?php

namespace App;

use App\BaseModel;

class ItemGroup extends BaseModel
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

    public function itemSubCategories()
    {
        return $this->hasMany('App\ItemSubCategory');
    }
}
