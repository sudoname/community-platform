<?php

namespace Database\Seeders;

use App\Models\Channel;
use Illuminate\Database\Seeder;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $channels = [
            [
                'name' => 'General',
                'description' => 'General discussion and community chat',
                'type' => 'text',
                'display_order' => 1,
                'is_private' => false,
                'required_role' => null,
            ],
            [
                'name' => 'Announcements',
                'description' => 'Important announcements and updates',
                'type' => 'announcement',
                'display_order' => 0,
                'is_private' => false,
                'required_role' => null,
            ],
            [
                'name' => 'Off-Topic',
                'description' => 'Random conversations and fun stuff',
                'type' => 'text',
                'display_order' => 2,
                'is_private' => false,
                'required_role' => null,
            ],
            [
                'name' => 'Help & Support',
                'description' => 'Get help from the community',
                'type' => 'text',
                'display_order' => 3,
                'is_private' => false,
                'required_role' => null,
            ],
            [
                'name' => 'Premium Members',
                'description' => 'Exclusive channel for paid members',
                'type' => 'text',
                'display_order' => 4,
                'is_private' => true,
                'required_role' => 'paid_member',
            ],
        ];

        foreach ($channels as $channel) {
            Channel::create($channel);
        }
    }
}
