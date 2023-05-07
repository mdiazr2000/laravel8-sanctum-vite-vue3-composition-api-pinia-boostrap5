<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'client',
            'guard_name' => 'web'
        ]);

        DB::table('roles')->insert([
            'name' => 'worker',
            'guard_name' => 'web'
        ]);
    }
}
