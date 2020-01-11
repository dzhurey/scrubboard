<?php

namespace App;

use App\BaseModel;

class Address extends BaseModel
{
    protected $fillable = [
        'customer_id',
        'is_billing',
        'is_shipping',
        'description',
        'district',
        'city',
        'country',
        'zip_code',
        'is_default',
    ];

    protected $searchable = [
        'customer__name',
        'city',
    ];

    protected $filterable = [
        'is_billing',
        'is_shipping',
        'customer_id',
        'is_default'
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function courierSchedules()
    {
        return $this->hasMany('App\CourierSchedule');
    }
}
