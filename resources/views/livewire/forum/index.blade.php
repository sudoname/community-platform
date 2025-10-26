<x-app-layout>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Forum Discussions</h1>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.forums.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-semibold">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Topic
                </a>
            @endif
        </div>

        <!-- Topics List -->
        <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
            @forelse($topics as $topic)
                <div class="border-b border-gray-200 hover:bg-gray-50 transition">
                    <a href="{{ route('forums.topic', $topic->slug) }}" class="block p-6">
                        <div class="flex justify-between items-start">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-2 mb-2">
                                    @if($topic->is_pinned)
                                        <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                                        </svg>
                                    @endif
                                    <h2 class="text-lg font-semibold text-gray-900 hover:text-indigo-600">
                                        {{ $topic->title }}
                                    </h2>
                                </div>

                                <p class="text-sm text-gray-600 line-clamp-2 mb-2">
                                    {{ Str::limit($topic->content, 150) }}
                                </p>

                                <div class="flex items-center space-x-4 text-xs text-gray-500">
                                    <span class="font-medium text-gray-700">{{ $topic->user->name }}</span>
                                    <span>{{ $topic->created_at->diffForHumans() }}</span>
                                    @if($topic->category)
                                        <span class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full">
                                            {{ $topic->category->name }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="ml-6 flex-shrink-0 text-center">
                                <div class="text-2xl font-bold text-gray-900">{{ $topic->replies_count }}</div>
                                <div class="text-xs text-gray-500">replies</div>
                                <div class="text-xs text-gray-500 mt-1">{{ $topic->views_count }} views</div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No topics yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new discussion topic.</p>
                    @if(auth()->user()->isAdmin())
                        <div class="mt-6">
                            <a href="{{ route('admin.forums.create') }}"
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-semibold">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                New Topic
                            </a>
                        </div>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($topics->hasPages())
            <div class="mt-6">
                {{ $topics->links() }}
            </div>
        @endif
    </div>
</div>
</x-app-layout>
