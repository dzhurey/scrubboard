<?php

namespace App;

use App\BaseModel;

class Courier extends BaseModel
{
    protected $fillable = [
        'name',
        'phone_number',
    ];

    protected $searchable = [
        'name',
    ];
}
