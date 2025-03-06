<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 real users with specific details
        $admin_password = env('DEFAULT_ADMIN_PASSWORD');
        $user_password = env('DEFAULT_USER_PASSWORD');

        $realUsers = [
            [
                'first_name' => 'Admin',
                'last_name' => 'Root',
                'email' => 'admin_root@gmail.com',
                'password' => $admin_password,
                'user_level' => 0,
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => $admin_password,
                'user_level' => 1,
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane@gmail.com',
                'password' => $user_password,
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@gmail.com',
                'password' => $user_password,
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'User',
                'last_name' => 'Johnson',
                'email' => 'user@gmail.com',
                'password' => $user_password,
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Accountant',
                'last_name' => 'Joseph',
                'email' => 'accountant@gmail.com',
                'password' => $user_password,
                'user_level' => 3,
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Store',
                'last_name' => 'Keeper',
                'email' => 'storekeeper@gmail.com',
                'password' => $user_password,
                'user_level' => 4,
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Librarian',
                'last_name' => 'Samuel',
                'email' => 'librarian@gmail.com',
                'password' => $user_password,
                'user_level' => 5,
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Principal',
                'last_name' => 'David',
                'email' => 'principal@gmail.com',
                'password' => $user_password,
                'user_level' => 6,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($realUsers as $user) {
            User::create($user);
        }

        // Create 10 fake users
        // User::factory(10)->create();
    }
}
