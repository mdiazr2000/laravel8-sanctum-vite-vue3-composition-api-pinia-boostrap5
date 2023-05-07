<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => 'add_book',
            'guard_name' => 'web'
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit_book',
            'guard_name' => 'web'
        ]);
        DB::table('permissions')->insert([
            'name' => 'delete_book',
            'guard_name' => 'web'
        ]);
        DB::table('permissions')->insert([
            'name' => 'see_book',
            'guard_name' => 'web'
        ]);
        DB::table('permissions')->insert([
            'name' => 'list_book',
            'guard_name' => 'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'add_reservation',
            'guard_name' => 'web'
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit_reservation',
            'guard_name' => 'web'
        ]);
        DB::table('permissions')->insert([
            'name' => 'delete_reservation',
            'guard_name' => 'web'
        ]);
        DB::table('permissions')->insert([
            'name' => 'see_reservation',
            'guard_name' => 'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'list_reservation',
            'guard_name' => 'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'add_user',
            'guard_name' => 'web'
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit_user',
            'guard_name' => 'web'
        ]);
        DB::table('permissions')->insert([
            'name' => 'delete_user',
            'guard_name' => 'web'
        ]);
        DB::table('permissions')->insert([
            'name' => 'see_user',
            'guard_name' => 'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'add_client',
            'guard_name' => 'web'
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit_client',
            'guard_name' => 'web'
        ]);
        DB::table('permissions')->insert([
            'name' => 'delete_client',
            'guard_name' => 'web'
        ]);
        DB::table('permissions')->insert([
            'name' => 'see_client',
            'guard_name' => 'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'list_client',
            'guard_name' => 'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'add_worker',
            'guard_name' => 'web'
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit_worker',
            'guard_name' => 'web'
        ]);
        DB::table('permissions')->insert([
            'name' => 'delete_worker',
            'guard_name' => 'web'
        ]);
        DB::table('permissions')->insert([
            'name' => 'see_worker',
            'guard_name' => 'web'
        ]);
    }
}
