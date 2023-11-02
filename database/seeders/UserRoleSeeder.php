<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default_user_value = [
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10)
        ];

        $role_staff = Role::where('name', "staff")->first();
        $role_admin = Role::where('name', "admin")->first();
        $role_manager = Role::where('name', "manager")->first();

        $admin = User::create(array_merge([
            'email' => 'admin@gmail.com',
            'name' => 'admin',
            'role_id' => $role_admin->id,
        ], $default_user_value));

        $staff = User::create(array_merge([
            'email' => 'staff@gmail.com',
            'name' => 'staff',
            'role_id' => $role_staff->id,
        ], $default_user_value));

        $manager = User::create(array_merge([
            'email' => 'manager@gmail.com',
            'name' => 'manager',
            'role_id' => $role_manager->id,
        ], $default_user_value));


        $staff->assignRole($role_staff->name);
        $admin->assignRole($role_admin->name);
        $manager->assignRole($role_manager->name);
    }
}
