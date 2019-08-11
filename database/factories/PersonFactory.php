<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Person;
use Faker\Generator as Faker;

$factory->define(Person::class, function (Faker $faker) {
    return [
        'name' => 'Zuhri Admin',
        'birth_date' => new DateTime(),
        'gender' => 'male',
        'religion' => 'islam',
        'phone_number' => '09876543212',
        'address' => 'yaya',
        'district' => 'yaya',
        'city' => 'yaya',
        'country' => 'yaya',
        'zip_code' => 'yaya',
        'created_at' => new DateTime()
    ];
});
