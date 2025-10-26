<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Notifications / Inbox
            </h2>
            @if($unreadCount > 0)
                <form method="POST" action="{{ route('notifications.markAllAsRead') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        Mark All as Read
                    </button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($unreadCount > 0)
                <div class="mb-4 bg-blue-50 border border-blue-400 text-blue-700 px-4 py-3 rounded">
                    You have {{ $unreadCount }} unread {{ Str::plural('notification', $unreadCount) }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @forelse($notifications as $notification)
                        @php
                            $data = $notification->data;
                            $isUnread = is_null($notification->read_at);
                            $priority = $data['priority'] ?? 'info';

                            $priorityColors = [
                                'info' => 'bg-blue-50 border-blue-200',
                                'success' => 'bg-green-50 border-green-200',
                                'warning' => 'bg-yellow-50 border-yellow-200',
                                'error' => 'bg-red-50 border-red-200',
                            ];

                            $priorityIcons = [
                                'info' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                                'success' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                                'warning' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
                                'error' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
                            ];
                        @endphp

                        <div class="mb-4 p-4 border rounded-lg {{ $priorityColors[$priority] ?? $priorityColors['info'] }} {{ $isUnread ? 'border-l-4 border-l-indigo-600' : '' }}">
                            <div class="flex items-start">
                                <!-- Icon -->
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-{{ $priority === 'error' ? 'red' : ($priority === 'warning' ? 'yellow' : ($priority === 'success' ? 'green' : 'blue')) }}-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $priorityIcons[$priority] ?? $priorityIcons['info'] }}" />
                                    </svg>
                                </div>

                                <!-- Content -->
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-semibold text-gray-900 {{ $isUnread ? 'font-bold' : '' }}">
                                            {{ $data['title'] ?? 'Notification' }}
                                        </h3>
                                        @if($isUnread)
                                            <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-indigo-600 text-white">
                                                New
                                            </span>
                                        @endif
                                    </div>

                                    <p class="mt-1 text-sm text-gray-700">
                                        {{ $data['message'] ?? '' }}
                                    </p>

                                    <div class="mt-2 flex items-center justify-between">
                                        <span class="text-xs text-gray-500">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>

                                        <div class="flex items-center gap-2">
                                            @if(isset($data['action_url']) && $data['action_url'])
                                                <a href="{{ $data['action_url'] }}"
                                                    class="text-xs font-medium text-indigo-600 hover:text-indigo-800">
                                                    {{ $data['action_text'] ?? 'View' }} →
                                                </a>
                                            @endif

                                            @if($isUnread)
                                                <form method="POST" action="{{ route('notifications.read', $notification->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-xs font-medium text-gray-600 hover:text-gray-800 underline">
                                                        Mark as Read
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications</h3>
                            <p class="mt-1 text-sm text-gray-500">You're all caught up!</p>
                        </div>
                    @endforelse

                    @if($notifications->hasPages())
                        <div class="mt-6">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
