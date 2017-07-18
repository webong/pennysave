<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    		$faker = Faker::create();
    		for ($i = 0; $i < 2; $i++) {
    			$user = User::create([
    				'id'            => $faker->uuid,
    				'first_name'    => $faker->firstName,
    				'last_name'     => $faker->lastName,
    				'email'         => $faker->email,
    				'password'      => bcrypt('gentle1'.$i),
    			]);
        }
    }
}
