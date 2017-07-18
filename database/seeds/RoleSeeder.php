<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'super_admin','display_name' => 'Super Admin','description' => 'User with Access To Entire Application'],
            ['name' => 'group_admin','display_name' => 'Group Admin','description' => 'User with Access To Group(s) created'],
            ['name' => 'user','display_name' => 'User','description' => 'User with Access To Personal Info only'],
        ]);
    }
}
