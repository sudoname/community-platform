<div class="flex h-screen bg-gray-100">
    <!-- Sidebar - Channel List -->
    <div class="w-64 bg-gray-800 text-white flex-shrink-0">
        <div class="p-4 border-b border-gray-700">
            <h2 class="text-xl font-semibold">Channels</h2>
        </div>
        <livewire:chat.channel-list :selectedChannelId="$selectedChannelId" />
    </div>

    <!-- Main Chat Area -->
    <div class="flex-1 flex flex-col">
        @if($selectedChannel)
            <!-- Chat Header -->
            <div class="bg-white border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900"># {{ $selectedChannel->name }}</h3>
                        @if($selectedChannel->description)
                            <p class="text-sm text-gray-500">{{ $selectedChannel->description }}</p>
                        @endif
                    </div>
                    @if($selectedChannel->is_private)
                        <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded">
                            Private
                        </span>
                    @endif
                </div>
            </div>

            <!-- Messages -->
            <div class="flex-1 overflow-y-auto bg-white">
                <livewire:chat.message-list :channelId="$selectedChannelId" :key="$selectedChannelId" />
            </div>

            <!-- Message Input -->
            <div class="bg-white border-t border-gray-200 p-4">
                <livewire:chat.message-form :channelId="$selectedChannelId" />
            </div>
        @else
            <!-- No Channel Selected -->
            <div class="flex-1 flex items-center justify-center bg-white">
                <div class="text-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Welcome to Chat</h3>
                    <p class="text-gray-500">Select a channel from the sidebar to start chatting</p>
                </div>
            </div>
        @endif
    </div>
</div>
