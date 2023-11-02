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

        $role_admin->givePermissionTo(['read-role', 'read-user-management']);
        $role_admin->givePermissionTo('create-role');
        $role_admin->givePermissionTo('update-role');
        $role_admin->givePermissionTo('delete-role');

        $role_staff->givePermissionTo('read-role');

    }
}
