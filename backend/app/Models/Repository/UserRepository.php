<?php

namespace App\Models\Repository;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserRepository
{
    public function loginUser($email = "", $password = "")
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return [
                'message' => 'Login invalid',
                'status' => 503,
                'token' => null,
                'permissionNames' => []
            ];
        }

        // Load the permissions for the user
        $permissionNames = $user->getPermissionsViaRoles();
        $roles = $user->getRoleNames()->toArray();
        $token = $user->createToken('SPA', array_column($permissionNames->toArray(), 'name'))->plainTextToken;

        $profileInfo = $user->profile;
        return [
            'message' => 'Login succesfull',
            'status' => 200,
            'token' => $token,
            'roles' => $roles,
            'profileInfo' => $profileInfo,
            'permissionNames' => array_column($permissionNames->toArray(), 'name')
        ];
    }

    public function saveUser(
        $email = "",
        $password = "",
        $role = "worker",
        $profileType = 'App\Models\Worker',
        $profileId = null
    )
    {
        $user = null;
        try {
            // Tell Laravel all the code beneath this is a transaction
            DB::beginTransaction();
            $user =  User::create([
                'name' => $email,
                'email' => $email,
                'password' => Hash::make($password),
                'profile_id' => $profileId,
                'profile_type' => $profileType
            ]);

            // Get the Role and assign to the user
            $roleModel = Role::where('name', $role)->first();

            if (isset($roleModel)) {
                $user->assignRole($role);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        return $user;
    }
}
