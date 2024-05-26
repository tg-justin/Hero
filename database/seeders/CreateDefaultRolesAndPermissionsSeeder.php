<?php

namespace Database\Seeders;
use Database\Factories\QuestFactory;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;


class CreateDefaultRolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Roles
        $roleAdmin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $roleEditor = Role::create(['name' => 'manager', 'guard_name' => 'web']);
        $roleUser = Role::create(['name' => 'hero',  'guard_name' => 'web']);

        // Create Permissions (adjust as needed)
        $permissionCreateUser = Permission::create(['name' => 'create-users',  'guard_name' => 'web']);
        $permissionEditUsers = Permission::create(['name' => 'edit-users',  'guard_name' => 'web']);
        $permissionDeleteUsers = Permission::create(['name' => 'delete-users', 'guard_name' => 'web']);

        // Assign Permissions to Roles (customize as needed)
        $roleAdmin->syncPermissions([$permissionCreateUser, $permissionEditUsers, $permissionDeleteUsers]);
        $roleEditor->syncPermissions([$permissionEditUsers]); // Editor can only edit

        
    }
}
