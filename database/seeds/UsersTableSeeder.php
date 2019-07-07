<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'muhammadszuhri@gmail.com',
            'password' => bcrypt('Scrubboard123'),
            'role' => 'superadmin',
            'created_at' => new DateTime()
        ]);
    }
}
