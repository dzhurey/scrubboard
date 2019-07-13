<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
