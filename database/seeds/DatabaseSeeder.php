<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BankSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(RecurrenceSeeder::class);
        $this->call(PriorityLevelSeeder::class);
    }
}
