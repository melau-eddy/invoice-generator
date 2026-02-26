<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions (if needed)
        // $permissions = ['view invoices', 'create invoices', 'edit invoices', 'delete invoices'];
        // foreach ($permissions as $permission) {
        //     Permission::create(['name' => $permission]);
        // }

        // Create roles
        $role = Role::create(['name' => 'user']);
        $adminRole = Role::create(['name' => 'admin']);
        
        // Assign permissions to roles (if you have permissions)
        // $role->givePermissionTo('view invoices');
        // $adminRole->givePermissionTo(['view invoices', 'create invoices', 'edit invoices', 'delete invoices']);

        // Assign admin role to an existing user (optional)
        $admin = User::where('email', 'admin@gmail.com')->first();
        if ($admin) {
            $admin->assignRole('admin');
        }

        $this->command->info('Roles and permissions created successfully!');
    }
}
