<?php

namespace App;

use App\BaseModel;

class Person extends BaseModel
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
        'phone_number',
        'address',
        'district',
        'city',
        'country',
        'zip_code',
    ];

    protected $searchable = [
        'name',
        'user__email',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function courierSchedules()
    {
        return $this->hasMany('App\CourierSchedule', 'person_id', 'id');
    }
}
