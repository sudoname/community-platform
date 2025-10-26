<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ auth()->user()->name }}'s Dashboard
            </h2>
            @if(auth()->user()->isAdmin())
                <div class="flex gap-2 flex-wrap">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Admin Panel
                    </a>
                    <a href="{{ route('admin.notifications.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                        </svg>
                        Send Notification
                    </a>
                    <a href="{{ route('admin.recommendations.index') }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700">
                        Manage Stocks
                    </a>
                    <a href="{{ route('admin.channels.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        + New Channel
                    </a>
                    <a href="{{ route('admin.forums.create') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700">
                        + New Forum Topic
                    </a>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Stock Marquee for Paid Members -->
            @if(auth()->user()->role === 'paid_member')
                @php
                    $marqueeStocks = \App\Models\Recommendation::active()->marquee()->ordered()->get();
                @endphp
                @if($marqueeStocks->count() > 0)
                    <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-3 overflow-hidden">
                            <div class="marquee-container">
                                <div class="marquee-content flex gap-8 animate-marquee">
                                    @foreach($marqueeStocks as $stock)
                                        <span class="flex items-center gap-2 whitespace-nowrap text-sm font-semibold">
                                            <span class="text-yellow-300">{{ $stock->stock_symbol }}</span>
                                            @if($stock->type === 'option')
                                                <span class="text-xs text-gray-200">{{ strtoupper($stock->option_type) }} ${{ number_format($stock->strike_price, 2) }} {{ $stock->expiration_date ? $stock->expiration_date->format('m/d/y') : '' }}</span>
                                            @endif
                                            <span class="px-2 py-1 rounded text-xs
                                                @if($stock->action === 'buy') bg-green-800
                                                @elseif($stock->action === 'sell') bg-red-800
                                                @else bg-yellow-600
                                                @endif">
                                                {{ strtoupper($stock->action) }}
                                            </span>
                                            @if($stock->price)
                                                <span class="text-gray-100">${{ number_format($stock->price, 2) }}</span>
                                            @endif
                                        </span>
                                    @endforeach
                                    @foreach($marqueeStocks as $stock)
                                        <span class="flex items-center gap-2 whitespace-nowrap text-sm font-semibold">
                                            <span class="text-yellow-300">{{ $stock->stock_symbol }}</span>
                                            @if($stock->type === 'option')
                                                <span class="text-xs text-gray-200">{{ strtoupper($stock->option_type) }} ${{ number_format($stock->strike_price, 2) }} {{ $stock->expiration_date ? $stock->expiration_date->format('m/d/y') : '' }}</span>
                                            @endif
                                            <span class="px-2 py-1 rounded text-xs
                                                @if($stock->action === 'buy') bg-green-800
                                                @elseif($stock->action === 'sell') bg-red-800
                                                @else bg-yellow-600
                                                @endif">
                                                {{ strtoupper($stock->action) }}
                                            </span>
                                            @if($stock->price)
                                                <span class="text-gray-100">${{ number_format($stock->price, 2) }}</span>
                                            @endif
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>
                        @keyframes marquee {
                            0% { transform: translateX(0); }
                            100% { transform: translateX(-50%); }
                        }
                        .animate-marquee {
                            animation: marquee 30s linear infinite;
                        }
                    </style>
                @endif
            @endif

            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-2">Welcome back, {{ auth()->user()->name }}!</h3>
                    <p class="text-gray-600">You're logged in as a <span class="font-semibold text-indigo-600">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</span></p>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Channels -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Active Channels</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ \App\Models\Channel::active()->count() }}</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('chat') }}" class="text-sm text-indigo-600 hover:text-indigo-900">Go to Chat →</a>
                        </div>
                    </div>
                </div>

                <!-- Forum Topics -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Forum Topics</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ \App\Models\ForumTopic::count() }}</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('forums') }}" class="text-sm text-green-600 hover:text-green-900">Browse Forums →</a>
                        </div>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Notifications</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ auth()->user()->unreadNotifications->count() }}</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('notifications.index') }}" class="text-sm text-purple-600 hover:text-purple-900">View Inbox →</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Recent Activity</h3>
                    <p class="text-gray-600">Your recent messages and forum posts will appear here.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
