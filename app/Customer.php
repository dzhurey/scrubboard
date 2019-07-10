<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
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

    protected $fillable = [
        'user_id',
        'name',
        'birth_date',
        'gender',
        'religion',
        'email',
        'phone_number',
    ];

    public function addresses()
    {
        return $this->hasMany('App\Address');
    }
}
