<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
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
            'is_email_verified' => 1,
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10)
        ];

        $role_user = Role::where('name', "user")->first();
        $role_admin = Role::where('name', "admin")->first();

        $admin = User::create(array_merge([
            'email' => 'admin@gmail.com',
            'name' => 'admin',
            'role_id' => $role_admin->id,
        ], $default_user_value));

        $user = User::create(array_merge([
            'email' => 'user@gmail.com',
            'name' => 'user',
            'role_id' => $role_user->id,
        ], $default_user_value));

        $admin->assignRole($role_admin->name);
        $user->assignRole($role_user->name);

        UserProfile::create([
            'user_id' => $admin->id
        ]);

        UserProfile::create([
            'user_id' => $user->id
        ]);

    }
}
