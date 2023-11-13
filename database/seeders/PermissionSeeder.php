<?php

namespace Database\Seeders;

use App\Models\Modul;
use App\Models\ModulPermission;
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
        $role = Modul::create(['name' => 'role']);
        $user = Modul::create(['name' => 'user']);
        $permission = Modul::create(['name' => 'permission']);
        $brand = Modul::create(['name' => 'brand']);
        $category = Modul::create(['name' => 'category']);
        $product = Modul::create(['name' => 'product']);
        $master = Modul::create(['name' => 'master']);

        $read_role = Permission::create(['name' => 'read-role' , 'modul_id' => $role->id, 'guard_name' => 'web']);
        $create_role = Permission::create(['name' => 'create-role' , 'modul_id' => $role->id, 'guard_name' => 'web']);
        $update_role = Permission::create(['name' => 'update-role' , 'modul_id' => $role->id,'guard_name' => 'web']);
        $delete_role = Permission::create(['name' => 'delete-role' , 'modul_id' => $role->id, 'guard_name' => 'web']);

        $user_management = Permission::create(['name' => 'read-user-management' , 'modul_id' => $master->id,'guard_name' => 'web']);
        $master_data = Permission::create(['name' => 'read-master-data' , 'modul_id' => $master->id, 'guard_name' => 'web']);

        $read_permission = Permission::create(['name' => 'read-permission' ,'modul_id' => $permission->id, 'guard_name' => 'web']);
        $create_permission = Permission::create(['name' => 'create-permission' ,'modul_id' => $permission->id, 'guard_name' => 'web']);
        $update_permission = Permission::create(['name' => 'update-permission' ,'modul_id' => $permission->id, 'guard_name' => 'web']);
        $delete_permission = Permission::create(['name' => 'delete-permission' ,'modul_id' => $permission->id, 'guard_name' => 'web']);

        $read_user = Permission::create(['name' => 'read-user' ,'modul_id' => $user->id,'guard_name' => 'web']);
        $create_user = Permission::create(['name' => 'create-user' ,'modul_id' => $user->id, 'guard_name' => 'web']);
        $update_user = Permission::create(['name' => 'update-user' ,'modul_id' => $user->id,'guard_name' => 'web']);
        $delete_user = Permission::create(['name' => 'delete-user' ,'modul_id' => $user->id,'guard_name' => 'web']);

        $read_brand = Permission::create(['name' => 'read-brand' ,'modul_id' => $brand->id, 'guard_name' => 'web']);
        $create_brand = Permission::create(['name' => 'create-brand' ,'modul_id' => $brand->id, 'guard_name' => 'web']);
        $update_brand = Permission::create(['name' => 'update-brand' ,'modul_id' => $brand->id, 'guard_name' => 'web']);
        $delete_brand = Permission::create(['name' => 'delete-brand' ,'modul_id' => $brand->id, 'guard_name' => 'web']);

        $read_category = Permission::create(['name' => 'read-category' ,'modul_id' => $category->id, 'guard_name' => 'web']);
        $create_category = Permission::create(['name' => 'create-category' ,'modul_id' => $category->id, 'guard_name' => 'web']);
        $update_category = Permission::create(['name' => 'update-category' ,'modul_id' => $category->id, 'guard_name' => 'web']);
        $delete_category = Permission::create(['name' => 'delete-category' ,'modul_id' => $category->id, 'guard_name' => 'web']);

        $read_product = Permission::create(['name' => 'read-product' ,'modul_id' => $product->id, 'guard_name' => 'web']);
        $create_product = Permission::create(['name' => 'create-product' ,'modul_id' => $product->id, 'guard_name' => 'web']);
        $update_product = Permission::create(['name' => 'update-product' ,'modul_id' => $product->id, 'guard_name' => 'web']);
        $delete_product = Permission::create(['name' => 'delete-product' ,'modul_id' => $product->id, 'guard_name' => 'web']);

        // ModulPermission::create(['modul_id' => $role->id, 'permission_id' => $read_role->id]);
        // ModulPermission::create(['modul_id' => $role->id, 'permission_id' => $create_role->id]);
        // ModulPermission::create(['modul_id' => $role->id, 'permission_id' => $update_role->id]);
        // ModulPermission::create(['modul_id' => $role->id, 'permission_id' => $delete_role->id]);

        // ModulPermission::create(['modul_id' => $permission->id, 'permission_id' => $read_permission->id]);
        // ModulPermission::create(['modul_id' => $permission->id, 'permission_id' => $create_permission->id]);
        // ModulPermission::create(['modul_id' => $permission->id, 'permission_id' => $update_permission->id]);
        // ModulPermission::create(['modul_id' => $permission->id, 'permission_id' => $delete_permission->id]);

        // ModulPermission::create(['modul_id' => $user->id, 'permission_id' => $read_user->id]);
        // ModulPermission::create(['modul_id' => $user->id, 'permission_id' => $create_user->id]);
        // ModulPermission::create(['modul_id' => $user->id, 'permission_id' => $update_user->id]);
        // ModulPermission::create(['modul_id' => $user->id, 'permission_id' => $delete_user->id]);

        // ModulPermission::create(['modul_id' => $brand->id, 'permission_id' => $read_brand->id]);
        // ModulPermission::create(['modul_id' => $brand->id, 'permission_id' => $create_brand->id]);
        // ModulPermission::create(['modul_id' => $brand->id, 'permission_id' => $update_brand->id]);
        // ModulPermission::create(['modul_id' => $brand->id, 'permission_id' => $delete_brand->id]);

        // ModulPermission::create(['modul_id' => $category->id, 'permission_id' => $read_category->id]);
        // ModulPermission::create(['modul_id' => $category->id, 'permission_id' => $create_category->id]);
        // ModulPermission::create(['modul_id' => $category->id, 'permission_id' => $update_category->id]);
        // ModulPermission::create(['modul_id' => $category->id, 'permission_id' => $delete_category->id]);

        // ModulPermission::create(['modul_id' => $product->id, 'permission_id' => $read_product->id]);
        // ModulPermission::create(['modul_id' => $product->id, 'permission_id' => $create_product->id]);
        // ModulPermission::create(['modul_id' => $product->id, 'permission_id' => $update_product->id]);
        // ModulPermission::create(['modul_id' => $product->id, 'permission_id' => $delete_product->id]);
    }
}
