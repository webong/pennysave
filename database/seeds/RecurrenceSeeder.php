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
           [ 'period' => 'Daily' ],
           [ 'period' => 'Weekly' ],
           [ 'period' => 'Fortnightly(Every Two Weeks)' ],
           [ 'period' => 'Monthly' ],
        ]);
    }
}
