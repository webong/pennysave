<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriorityLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('priority_levels')->insert([
           [ 'priority_level' => 'Low' ],
           [ 'priority_level' => 'Normal' ],
           [ 'priority_level' => 'Medium' ],
           [ 'priority_level' => 'High' ],
        ]);

    }
}
