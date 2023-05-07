<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $passwordHash = Hash::make('12345678');
        $worker = DB::table('workers')
            ->where('name', 'worker1')
            ->select('workers.id')
            ->first();
        DB::table('users')->insert([
            'name' => 'worker1',
            'email' => 'worker1@gmail.com',
            'password' => $passwordHash,
            'profile_id' => $worker->id,
            'profile_type' => 'App\Models\Worker'
        ]);
        $worker = DB::table('workers')
            ->where('name', 'worker2')
            ->select('workers.id')
            ->first();
        DB::table('users')->insert([
            'name' => 'worker2',
            'email' => 'worker2@gmail.com',
            'password' => $passwordHash,
            'profile_id' => $worker->id,
            'profile_type' => 'App\Models\Worker'
        ]);
        $worker = DB::table('workers')
            ->where('name', 'worker3')
            ->select('workers.id')
            ->first();
        DB::table('users')->insert([
            'name' => 'worker3',
            'email' => 'worker3@gmail.com',
            'password' => $passwordHash,
            'profile_id' => $worker->id,
            'profile_type' => 'App\Models\Worker'
        ]);
    }
}
