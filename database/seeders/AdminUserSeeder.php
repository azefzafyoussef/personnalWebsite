<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create single admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@noteshub.com',
            'password' => Hash::make('password123'),
            'is_admin' => true,
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@noteshub.com');
        $this->command->info('Password: password123');
    }
}