<div class="p-6 space-y-4">
    @forelse($messages as $message)
        <div class="flex space-x-3">
            <!-- Avatar -->
            <div class="flex-shrink-0">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white font-semibold">
                    {{ strtoupper(substr($message->user->name, 0, 1)) }}
                </div>
            </div>

            <!-- Message Content -->
            <div class="flex-1 min-w-0">
                <div class="flex items-baseline space-x-2">
                    <span class="font-semibold text-gray-900">{{ $message->user->name }}</span>
                    <span class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                    @if($message->is_edited)
                        <span class="text-xs text-gray-400">(edited)</span>
                    @endif
                </div>

                <!-- Reply Context -->
                @if($message->replyTo)
                    <div class="mt-1 pl-3 border-l-2 border-gray-300 text-sm text-gray-600">
                        <span class="font-medium">@{{ $message->replyTo->user->name }}</span>
                        <span class="text-gray-500">{{ Str::limit($message->replyTo->content, 50) }}</span>
                    </div>
                @endif

                <!-- Message Text -->
                <div class="mt-1 text-gray-800 break-words">
                    {{ $message->content }}
                </div>

                @if($message->is_pinned)
                    <div class="mt-1">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                            </svg>
                            Pinned
                        </span>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center py-12 text-gray-500">
            <p>No messages yet. Be the first to say something!</p>
        </div>
    @endforelse
</div>
