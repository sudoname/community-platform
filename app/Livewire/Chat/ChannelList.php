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

        $channels = Channel::active()
            ->ordered()
            ->where(function($query) use ($user) {
                $query->where('is_private', false)
                    ->orWhere(function($q) use ($user) {
                        // Show private channels based on user role
                        $q->where('is_private', true)
                          ->where(function($roleQuery) use ($user) {
                              if ($user->isAdmin()) {
                                  $roleQuery->whereIn('required_role', ['admin', 'paid_member', 'free_member']);
                              } elseif ($user->isPaidMember()) {
                                  $roleQuery->whereIn('required_role', ['paid_member', 'free_member']);
                              } else {
                                  $roleQuery->where('required_role', 'free_member');
                              }
                          });
                    });
            })
            ->get();

        return view('livewire.chat.channel-list', [
            'channels' => $channels,
        ]);
    }
}
