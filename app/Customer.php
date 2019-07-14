<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Address;

class Customer extends Model
{
    const GENDERS = [
        'male' => 'Laki-Laki',
        'female' => 'Perempuan',
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
        'belief' => 'Kepercayaan',
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
    ];

    public function addresses()
    {
        return $this->hasMany('App\Address');
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
}
