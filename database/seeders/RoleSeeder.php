<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Administrator',
                'slug' => 'admin',
                'description' => 'Full access to all system features',
                'permissions' => [
                    'manage_users',
                    'manage_devices',
                    'manage_rentals',
                    'manage_categories',
                    'manage_reviews',
                    'manage_settings',
                ],
            ],
            [
                'name' => 'Customer',
                'slug' => 'customer',
                'description' => 'Regular customer with basic rental privileges',
                'permissions' => [
                    'rent_devices',
                    'view_devices',
                    'manage_own_rentals',
                    'write_reviews',
                ],
            ],
            [
                'name' => 'Staff',
                'slug' => 'staff',
                'description' => 'Staff member with device and rental management privileges',
                'permissions' => [
                    'manage_devices',
                    'manage_rentals',
                    'manage_reviews',
                    'view_reports',
                ],
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
} 