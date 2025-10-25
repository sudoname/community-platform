<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@community.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create paid member
        User::create([
            'name' => 'Premium Member',
            'email' => 'premium@community.test',
            'password' => Hash::make('password'),
            'role' => 'paid_member',
            'is_active' => true,
        ]);

        // Create free member
        User::create([
            'name' => 'Free Member',
            'email' => 'free@community.test',
            'password' => Hash::make('password'),
            'role' => 'free_member',
            'is_active' => true,
        ]);

        // Seed channels and forum categories
        $this->call([
            ChannelSeeder::class,
            ForumCategorySeeder::class,
        ]);
    }
}
