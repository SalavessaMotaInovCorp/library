<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin and Citizen roles
        $role_admin = Role::create(['name' => 'admin']);
        $role_citizen = Role::create(['name' => 'citizen']);

        $permission_read = Permission::create(['name' => 'read']);
        $permissions_export = Permission::create(['name' => 'export']);
        $permission_create = Permission::create(['name' => 'create']);
        $permission_update = Permission::create(['name' => 'update']);
        $permission_delete = Permission::create(['name' => 'delete']);

        $permissions_admin = [
            $permission_read,
            $permissions_export,
            $permission_create,
            $permission_update,
            $permission_delete,
        ];

        $role_admin->syncPermissions($permissions_admin);
        $role_citizen->givePermissionTo($permission_read);
    }
}
