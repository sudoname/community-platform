<div class="overflow-y-auto">
    @forelse($channels as $channel)
        <button
            wire:click="selectChannel({{ $channel->id }})"
            class="w-full text-left px-4 py-3 hover:bg-gray-700 transition flex items-center justify-between group
                {{ $selectedChannelId == $channel->id ? 'bg-gray-700 border-l-4 border-blue-500' : 'border-l-4 border-transparent' }}">
            <div class="flex items-center space-x-2 flex-1">
                <span class="text-gray-400">#</span>
                <span class="truncate">{{ $channel->name }}</span>
            </div>
            @if($channel->is_private)
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                </svg>
            @endif
        </button>
    @empty
        <div class="px-4 py-8 text-center text-gray-400 text-sm">
            No channels available
        </div>
    @endforelse
</div>
