<?php

namespace App;

use App\BaseModel;

class Agent extends BaseModel
{
    protected $fillable = [
        'name',
        'phone_number',
        'mobile_number',
        'email',
        'address',
        'sub_district',
        'district',
        'city',
        'country',
        'zip_code',
        'contact_name',
        'contact_phone_number',
        'contact_mobile_number',
    ];

    protected $searchable = [
        'name',
        'email',
        'contact_name',
    ];
}
