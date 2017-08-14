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
           [ 'id' => 1, 'priority_level' => 'Low' ],
           [ 'id' => 2, 'priority_level' => 'Normal' ],
           [ 'id' => 3, 'priority_level' => 'Medium' ],
           [ 'id' => 4, 'priority_level' => 'High' ],
        ]);

    }
}
