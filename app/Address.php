<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
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
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
