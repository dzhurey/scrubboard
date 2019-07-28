<?php

use Illuminate\Database\Seeder;

class AgentGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('agent_groups')->insert([
            'name' => 'Direct'
        ]);
    }
}
