<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Channel;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Chat channel authorization
Broadcast::channel('chat.channel.{channelId}', function ($user, $channelId) {
    $channel = Channel::find($channelId);

    if (!$channel || !$channel->is_active) {
        return false;
    }

    // Check if user's role is in allowed_roles
    $allowedRoles = $channel->allowed_roles ?? ['admin', 'paid_member', 'free_member'];

    if (in_array($user->role, $allowedRoles)) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'avatar' => $user->avatar ?? null,
        ];
    }

    return false;
});
