<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;
use App\helper\RolePermission;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['name' => 'create_user']);
        Permission::create(['name' => 'update_user']);
        Permission::create(['name' => 'delete_user']);
        Permission::create(['name' => 'access_user']);
        Permission::create(['name' => 'create_post']);
        Permission::create(['name' => 'update_post']);
        Permission::create(['name' => 'delete_post']);
        Permission::create(['name' => 'access_post']);
        Permission::create(['name' => 'manage_role']);
        Permission::create(['name' => 'create_invoice']);
        Permission::create(['name' => 'update_invoice']);
        Permission::create(['name' => 'delete_invoice']);
        Permission::create(['name' => 'access_invoice']);
        Permission::create(['name' => 'create_company']);
        Permission::create(['name' => 'update_company']);
        Permission::create(['name' => 'delete_company']);
        Permission::create(['name' => 'access_company']);

        Role::create(['name' => 'admin'])->givePermissionTo(Permission::all());
        Role::create(['name' => 'user'])->givePermissionTo(['access_user', 'create_user', 'access_post', 'create_post']);



    }
}
