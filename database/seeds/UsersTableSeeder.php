<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 1)->create()->each(function ($user) {
            $user->person()->save(factory(App\Person::class)->make());
        });

        DB::table('users')->insert(
            [
                'email' => 'erwin@gmail.com',
                'password' => 'Scrubboard123',
                'role' => 'courier',
                'created_at' => new DateTime(),
            ]
        );

        DB::table('people')->insert(
            [
                'name' => 'Erwin courier',
                'birth_date' => new DateTime(),
                'gender' => 'male',
                'religion' => 'islam',
                'phone_number' => '09876543212',
                'address' => 'yaya',
                'district' => 'yaya',
                'city' => 'yaya',
                'country' => 'yaya',
                'zip_code' => 'yaya',
                'created_at' => new DateTime(),
                'user_id' => User::where('email', '=', 'erwin@gmail.com')->first()->id,
            ]
        );
    }
}
