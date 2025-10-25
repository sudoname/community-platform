<?php

namespace Database\Seeders;

use App\Models\ForumCategory;
use Illuminate\Database\Seeder;

class ForumCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'General Discussion',
                'description' => 'General topics and community discussions',
                'icon' => '💬',
                'display_order' => 1,
            ],
            [
                'name' => 'Announcements',
                'description' => 'Official announcements and news',
                'icon' => '📢',
                'display_order' => 0,
            ],
            [
                'name' => 'Help & Support',
                'description' => 'Get help with questions and issues',
                'icon' => '❓',
                'display_order' => 2,
            ],
            [
                'name' => 'Feature Requests',
                'description' => 'Suggest new features and improvements',
                'icon' => '💡',
                'display_order' => 3,
            ],
            [
                'name' => 'Introductions',
                'description' => 'Introduce yourself to the community',
                'icon' => '👋',
                'display_order' => 4,
            ],
            [
                'name' => 'Off-Topic',
                'description' => 'Everything else!',
                'icon' => '🎲',
                'display_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            ForumCategory::create($category);
        }
    }
}
