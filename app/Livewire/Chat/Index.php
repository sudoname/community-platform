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
        $firstChannel = Channel::active()
            ->ordered()
            ->where(function($query) {
                $query->where('is_private', false)
                    ->orWhere(function($q) {
                        // Allow access to private channels based on role
                        $q->where('is_private', true)
                          ->where(function($roleQuery) {
                              $user = auth()->user();
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
        return view('livewire.chat.index')->layout('layouts.app');
    }
}
