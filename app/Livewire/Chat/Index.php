<?php

namespace App\Livewire\Chat;

use App\Models\Channel;
use Livewire\Component;
use Livewire\Attributes\On;

class Index extends Component
{
    public $selectedChannelId;
    public $selectedChannel;

    public function mount()
    {
        // Select the first available channel by default
        $user = auth()->user();
        $userRole = $user->role;

        // Get all active channels and filter by role in PHP (for SQLite compatibility)
        $firstChannel = Channel::active()
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
            })
            ->first();

        if ($firstChannel) {
            $this->selectChannel($firstChannel->id);
        }
    }

    #[On('channel-selected')]
    public function selectChannel($channelId)
    {
        $this->selectedChannelId = $channelId;
        $this->selectedChannel = Channel::find($channelId);

        // Notify child components
        $this->dispatch('channel-changed', channelId: $channelId);
    }

    public function render()
    {
        return view('livewire.chat.index');
    }
}
