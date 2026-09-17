<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Fetch the admin role dynamically from DB
        $adminRole = Role::where('name', 'admin')->first();

        if ($adminRole) {
            // 2. Create or update the Admin user
            User::firstOrCreate(
                ['email' => 'admin@example.com'], // Unique identifier
                [
                    'name'     => 'System Admin',
                    'password' => Hash::make('password123'), // Replace with your secure password
                    'role_id'  => $adminRole->id,
                ]
            );
        }
    }
}
