<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    const GENDERS = [
        'male' => 'Laki-Laki',
        'female' => 'Perempuan',
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

    const ROLES = [
        'superadmin' => 'Superadmin',
        'sales' => 'Sales',
        'finance' => 'Finance',
        'operation' => 'Operation',
        'courier' => 'Kurir',
        'workshop' => 'Workshop',
    ];

    protected $fillable = [
        'user',
        'name',
        'birth_date',
        'password',
        'gender',
        'religion',
        'phone_number',
        'address',
        'district',
        'city',
        'country',
        'zip_code',
        'role',
    ];

    public function user()
    {
        return $this->hasOne('App\User');
    }
}
