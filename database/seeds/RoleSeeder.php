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
            [ 'id' => 1, 'name' => 'super_admin','display_name' => 'Super Admin','description' => 'User with Access To Entire Application' ],
            [ 'id' => 2, 'name' => 'group_admin','display_name' => 'Group Admin','description' => 'User with Access To Group(s) created' ],
            [ 'id' => 3, 'name' => 'user','display_name' => 'User','description' => 'User with Access To Personal Info only' ],
        ]);
    }
}
