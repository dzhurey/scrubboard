<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = [
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
