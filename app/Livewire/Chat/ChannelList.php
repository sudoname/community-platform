<?php

namespace App\Livewire\Chat;

use App\Models\Channel;
use Livewire\Component;

class ChannelList extends Component
{
    public $selectedChannelId;

    public function selectChannel($channelId)
    {
        $this->selectedChannelId = $channelId;
        $this->dispatch('channel-selected', channelId: $channelId);
    }

    public function render()
    {
        $user = auth()->user();
        $userRole = $user->role;

        // Get all active channels and filter by role in PHP (for SQLite compatibility)
        $channels = Channel::active()
            ->ordered()
            ->get()
            ->filter(function($channel) use ($userRole) {
                $allowedRoles = $channel->allowed_roles;

                // Handle if allowed_roles is a JSON string (cast not working)
                if (is_string($allowedRoles)) {
                    $allowedRoles = json_decode($allowedRoles, true);
                }

                // If allowed_roles is null or empty, allow all
                if (empty($allowedRoles)) {
                    return true;
                }

                // Check if user's role is in allowed_roles array
                return in_array($userRole, $allowedRoles);
            });

        return view('livewire.chat.channel-list', [
            'channels' => $channels,
        ]);
    }
}
