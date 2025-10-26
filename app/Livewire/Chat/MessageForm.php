<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use App\Events\MessageSent;
use Livewire\Component;
use Livewire\Attributes\On;

class MessageForm extends Component
{
    public $channelId;
    public $content = '';
    public $replyToMessageId = null;

    #[On('channel-changed')]
    public function onChannelChanged($channelId)
    {
        $this->channelId = $channelId;
        $this->content = '';
        $this->replyToMessageId = null;
    }

    public function sendMessage()
    {
        $this->validate([
            'content' => 'required|string|max:2000',
        ]);

        if (!$this->channelId) {
            $this->addError('content', 'Please select a channel first.');
            return;
        }

        $message = Message::create([
            'channel_id' => $this->channelId,
            'user_id' => auth()->id(),
            'content' => $this->content,
            'reply_to_message_id' => $this->replyToMessageId,
        ]);

        // Extract and sync hashtags from content
        $message->syncTagsFromContent();

        // Broadcast the message to all users in the channel
        broadcast(new MessageSent($message))->toOthers();

        $this->content = '';
        $this->replyToMessageId = null;

        // Notify MessageList to reload locally
        $this->dispatch('message-sent');
    }

    public function render()
    {
        return view('livewire.chat.message-form');
    }
}
