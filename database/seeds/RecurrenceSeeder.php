<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecurrenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('recurrences')->insert([
           [ 'id' => 1, 'period' => 'Daily' ],
           [ 'id' => 2, 'period' => 'Weekly' ],
           [ 'id' => 3, 'period' => 'Fortnightly (Every Two Weeks)' ],
           [ 'id' => 4, 'period' => 'Monthly' ],
        ]);
    }
}
