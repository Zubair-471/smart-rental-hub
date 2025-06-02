<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'phone' => '+1234567890',
                'address' => '123 Admin Street, Tech City',
                'email_verified_at' => now()
            ]
        );

        // Create staff users
        $staffUsers = [
            [
                'name' => 'John Staff',
                'email' => 'john.staff@example.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'phone' => '+1234567891',
                'address' => '456 Staff Road, Service Town',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Sarah Manager',
                'email' => 'sarah.manager@example.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'phone' => '+1234567892',
                'address' => '789 Manager Ave, Support City',
                'email_verified_at' => now()
            ]
        ];

        foreach ($staffUsers as $staffData) {
            User::updateOrCreate(
                ['email' => $staffData['email']],
                $staffData
            );
        }

        // Create regular users
        $regularUsers = [
            [
                'name' => 'Alice Customer',
                'email' => 'alice@example.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'phone' => '+1234567893',
                'address' => '101 Customer Lane, User City',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Bob Renter',
                'email' => 'bob@example.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'phone' => '+1234567894',
                'address' => '202 Renter Street, Client Town',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Carol Smith',
                'email' => 'carol@example.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'phone' => '+1234567895',
                'address' => '303 User Road, Customer City',
                'email_verified_at' => now()
            ]
        ];

        foreach ($regularUsers as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        // Assign roles to users
        $adminRole = Role::where('slug', 'admin')->first();
        $staffRole = Role::where('slug', 'staff')->first();
        $customerRole = Role::where('slug', 'customer')->first();

        // Assign admin role
        $adminUser->roles()->sync([$adminRole->id]);

        // Assign staff roles
        User::whereIn('email', ['john.staff@example.com', 'sarah.manager@example.com'])
            ->get()
            ->each(function ($user) use ($staffRole) {
                $user->roles()->sync([$staffRole->id]);
            });

        // Assign customer roles
        User::whereIn('email', ['alice@example.com', 'bob@example.com', 'carol@example.com'])
            ->get()
            ->each(function ($user) use ($customerRole) {
                $user->roles()->sync([$customerRole->id]);
            });
    }
}
