<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; // Also required for remember_token
use App\Models\User; 

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
        ['email' => 'admin@example.com'],
        [
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin@123'), // Use a strong password
            'role' => 'admin',
            'status' => 'active', // if you have this field
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]
    );
    }
}
