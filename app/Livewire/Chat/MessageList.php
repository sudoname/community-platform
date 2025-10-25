<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use Livewire\Component;
use Livewire\Attributes\On;

class MessageList extends Component
{
    public $channelId;
    public $messages = [];

    public function mount($channelId = null)
    {
        $this->channelId = $channelId;
        $this->loadMessages();
    }

    #[On('channel-changed')]
    public function onChannelChanged($channelId)
    {
        $this->channelId = $channelId;
        $this->loadMessages();
    }

    #[On('message-sent')]
    public function onMessageSent()
    {
        $this->loadMessages();
    }

    public function loadMessages()
    {
        if (!$this->channelId) {
            $this->messages = [];
            return;
        }

        $this->messages = Message::with('user', 'replyTo.user')
            ->where('channel_id', $this->channelId)
            ->orderBy('created_at', 'asc')
            ->limit(100)
            ->get();
    }

    public function render()
    {
        return view('livewire.chat.message-list');
    }
}
