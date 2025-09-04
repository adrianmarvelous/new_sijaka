<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or get the Admin role
        $adminRole = Role::firstOrCreate(['name' => 'super admin']);

        // Define default permissions for admin
        $permissions = [
            'manage users',
            'manage roles',
            'manage permissions',
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Give all permissions to admin role
        $adminRole->syncPermissions(Permission::all());

        // Create or get an admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'adrianmarvelugr@gmail.com'], // unique by email
            [
                'username' => 'adrianmarvel',
                'name' => 'Super Admin',
                'password' => bcrypt('greenpurple'), // change later
            ]
        );

        // Assign admin role to the user (safe multiple runs)
        if (! $adminUser->hasRole('admin')) {
            $adminUser->assignRole($adminRole);
        }
    }
}
