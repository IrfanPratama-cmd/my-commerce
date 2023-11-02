<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission = Permission::create(['name' => 'read-role' , 'guard_name' => 'web']);
        $permission = Permission::create(['name' => 'create-role' , 'guard_name' => 'web']);
        $permission = Permission::create(['name' => 'update-role' , 'guard_name' => 'web']);
        $permission = Permission::create(['name' => 'delete-role' , 'guard_name' => 'web']);

        $permission = Permission::create(['name' => 'read-user-management' , 'guard_name' => 'web']);
    }
}
