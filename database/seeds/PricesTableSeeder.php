<?php

use Illuminate\Database\Seeder;

class PricesTableSeeder extends Seeder
{
    protected $prices = [
        ['name' => 'Pricelist 1'],
        ['name' => 'Pricelist 2'],
        ['name' => 'Pricelist 3'],
        ['name' => 'Pricelist 4'],
        ['name' => 'Pricelist 5'],
        ['name' => 'Pricelist 6'],
        ['name' => 'Pricelist 7'],
        ['name' => 'Pricelist 8'],
        ['name' => 'Pricelist 9'],
        ['name' => 'Pricelist 10'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('prices')->insert($this->prices);
    }
}
