<div>
    <form wire:submit="sendMessage" class="flex items-end space-x-2">
        <div class="flex-1">
            <textarea
                wire:model="content"
                rows="1"
                placeholder="Type your message..."
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                style="min-height: 48px; max-height: 200px;"
                @keydown.enter.prevent="if(!$event.shiftKey) { $wire.sendMessage(); $event.target.value = ''; }"
            ></textarea>
            @error('content')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button
            type="submit"
            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition font-medium disabled:opacity-50 disabled:cursor-not-allowed"
            wire:loading.attr="disabled">
            <span wire:loading.remove>Send</span>
            <span wire:loading>
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </span>
        </button>
    </form>

    <p class="mt-2 text-xs text-gray-500">
        Press Enter to send, Shift+Enter for new line
    </p>
</div>
