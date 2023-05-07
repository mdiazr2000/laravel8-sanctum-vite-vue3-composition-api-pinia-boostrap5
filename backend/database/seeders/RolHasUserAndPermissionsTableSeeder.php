<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolHasUserAndPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('users')
            ->where('name', 'worker1')
            ->select('users.id', 'users.email')
            ->first();

        $rolWorker = DB::table('roles')
            ->where('name', 'worker')
            ->select('roles.id', 'roles.name')
            ->first();
        DB::table('model_has_roles')->insert([
            'role_id' => $rolWorker->id,
            'model_id' => $user->id,
            'model_type'=>'App\Models\User'
        ]);

        $user = DB::table('users')
            ->where('name', 'worker2')
            ->select('users.id', 'users.email')
            ->first();

        DB::table('model_has_roles')->insert([
            'role_id' => $rolWorker->id,
            'model_id' => $user->id,
            'model_type'=>'App\Models\User'
        ]);

        $user = DB::table('users')
            ->where('name', 'worker3')
            ->select('users.id', 'users.email')
            ->first();

        DB::table('model_has_roles')->insert([
            'role_id' => $rolWorker->id,
            'model_id' => $user->id,
            'model_type'=>'App\Models\User'
        ]);

        $permissions = DB::table('permissions')
            ->select('permissions.id', 'permissions.name')
            ->get();

        $rolClient = DB::table('roles')
            ->where('name', 'client')
            ->select('roles.id', 'roles.name')
            ->first();

        $allowedPermissionForClient = ['add_reservation', 'edit_reservation', 'delete_reservation',
            'see_reservation', 'add_client', 'edit_client', 'delete_client', 'see_client', 'see_book', 'list_book',
            'list_reservation'];
        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')->insert([
                'role_id' => $rolWorker->id,
                'permission_id' => $permission->id,
            ]);
            if (in_array($permission->name, $allowedPermissionForClient)) {
                DB::table('role_has_permissions')->insert([
                    'role_id' => $rolClient->id,
                    'permission_id' => $permission->id,
                ]);
            }
        }
    }
}
