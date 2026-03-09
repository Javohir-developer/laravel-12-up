<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'create user',
            'edit user',
            'delete user',
            'publish articles',
            'unpublish articles'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // create roles and assign created permissions
        $role = Role::firstOrCreate(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        // supervisor role
        $role = Role::firstOrCreate(['name' => 'manager']);
        $role->givePermissionTo(['publish articles', 'unpublish articles', 'edit user']);

        $role = Role::firstOrCreate(['name' => 'user']);
        // simple users typically don't get much by default
    }
}
