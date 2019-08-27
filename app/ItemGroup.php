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

    public function items()
    {
        return $this->hasMany('App\Item');
    }
}
