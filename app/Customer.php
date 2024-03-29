<?php

namespace App;

use App\BaseModel;
use App\Address;

class Customer extends BaseModel
{
    const GENDERS = [
        'male' => 'male',
        'female' => 'female',
    ];

    const PARTNER_TYPE = [
        'customer' => 'customer',
        'vendor' => 'vendor',
        'endorser' => 'endorser',
    ];

    const RELIGIONS = [
        'islam' => 'Islam',
        'christian' => 'Kristen',
        'catholic' => 'Katolik',
        'hindu' => 'Hindu',
        'buddhis' => 'Budha',
        'kong hu chu' => 'Kong Hu Chu',
    ];

    protected $fillable = [
        'partner_type',
        'name',
        'birth_date',
        'gender',
        'religion',
        'email',
        'phone_number',
        'bebe_name',
        'bebe_gender',
        'bebe_birth_date',
        'price_id',
        'instagram',
    ];

    protected $searchable = [
        'name',
        'bebe_name',
        'email',
    ];

    public function addresses()
    {
        return $this->hasMany('App\Address');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    public function price()
    {
        return $this->belongsTo('App\Price');
    }

    public function billingAddress()
    {
        $billing = Address::where([
            ['customer_id', '=', $this->id],
            ['is_billing', '=', true],
        ])->first();

        if (empty($billing)) {
            $billing = new Address();
            $billing->is_billing = true;
        }

        return $billing;
    }

    public function shippingAddress()
    {
        $shipping = Address::where([
            ['customer_id', '=', $this->id],
            ['is_shipping', '=', true],
        ])->first();

        if (empty($shipping)) {
            $shipping = new Address();
            $shipping->is_shipping = true;
        }

        return $shipping;
    }

    public function isSameAddress()
    {
        return $this->billingAddress()->id == $this->shippingAddress()->id;
    }
}
