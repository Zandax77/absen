<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin; // We'll create a simple model if needed
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only create default admin if none exists
        if (Admin::count() === 0) {
            Admin::create([
                'username' => env('ADMIN_USERNAME', 'admin'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'admin123')),
            ]);
        }
    }
}
