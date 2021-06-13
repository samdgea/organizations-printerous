<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleSuperAdmin = Role::create(['name' => 'super-admin']);
        $roleAccountManager = Role::create(['name' => 'account-manager']);

        $permissionUserC = Permission::create(['name' => 'create-new-user']);
        $permissionUserR = Permission::create(['name' => 'view-user-management']);
        $permissionUserU = Permission::create(['name' => 'update-user']);
        $permissionUserD = Permission::create(['name' => 'delete-user']);

        $permissionRoleC = Permission::create(['name' => 'create-new-role']);
        $permissionRoleR = Permission::create(['name' => 'view-role-management']);
        $permissionRoleU = Permission::create(['name' => 'update-role']);
        $permissionRoleD = Permission::create(['name' => 'delete-role']);

        $permissionOrgC = Permission::create(['name' => 'create-new-organization']);
        $permissionOrgR = Permission::create(['name' => 'view-organization']);
        $permissionOrgU = Permission::create(['name' => 'update-organization']);
        $permissionOrgD = Permission::create(['name' => 'delete-organization']);
    }
}
