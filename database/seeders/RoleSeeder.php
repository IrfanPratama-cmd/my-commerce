<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_staff = Role::create(['name' => 'staff', 'guard_name' => 'web']);
        $role_admin = Role::create(['name' => 'admin' , 'guard_name' => 'web']);
        $role_manager = Role::create(['name' => 'manager' , 'guard_name' => 'web']);

        $role_admin->givePermissionTo(['read-master-data', 'read-user-management']);
        $role_admin->givePermissionTo(['read-role','create-role', 'update-role', 'delete-role']);
        $role_admin->givePermissionTo(['read-permission','create-permission', 'update-permission', 'delete-permission']);
        $role_admin->givePermissionTo(['read-user','create-user', 'update-user', 'delete-user']);
        $role_admin->givePermissionTo(['read-brand','create-brand', 'update-brand', 'delete-brand']);
        $role_admin->givePermissionTo(['read-category','create-category', 'update-category', 'delete-category']);
        $role_admin->givePermissionTo(['read-product','create-product', 'update-product', 'delete-product']);

        $role_staff->givePermissionTo('read-role');

    }
}
