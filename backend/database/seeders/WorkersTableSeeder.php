<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

class WorkersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // set worker
        DB::table('workers')->insert([
            'name' => 'worker1',
            'lastname' =>  $faker->lastName
        ]);
        $user = DB::table('users')
            ->where('name', 'worker2')
            ->select('users.id', 'users.email')
            ->first();
        DB::table('workers')->insert([
            'name' => 'worker2',
            'lastname' =>  $faker->lastName,
        ]);
        $user = DB::table('users')
            ->where('name', 'worker3')
            ->select('users.id', 'users.email')
            ->first();
        DB::table('workers')->insert([
            'name' => 'worker3',
            'lastname' =>  $faker->lastName,
        ]);
    }
}
