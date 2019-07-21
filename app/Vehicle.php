<?php

namespace App;

use App\BaseModel;

class Vehicle extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
    ];

    protected $searchable = [
        'number',
    ];
}
