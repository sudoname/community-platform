<x-app-layout>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <!-- Topic Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        @if($editingTopicId === $topic->id)
                            <!-- Edit Topic Form -->
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                    <input type="text" wire:model="editTopicTitle"
                                           class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                                    <textarea wire:model="editTopicContent" rows="5"
                                              class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                                </div>
                                <div class="flex gap-2">
                                    <button wire:click="saveEditTopic"
                                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                        Save Topic
                                    </button>
                                    <button wire:click="cancelEditTopic"
                                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        @else
                            <!-- Display Topic -->
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $topic->title }}</h1>
                            <div class="flex items-center text-sm text-gray-600 space-x-4">
                                <span class="font-semibold">{{ $topic->user->name }}</span>
                                <span>{{ $topic->created_at->diffForHumans() }}</span>
                                @if($topic->category)
                                    <span class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs">
                                        {{ $topic->category->name }}
                                    </span>
                                @endif
                                <span>{{ $topic->views_count }} views</span>
                                <span>{{ $topic->replies_count }} replies</span>
                            </div>
                        @endif
                    </div>

                    <!-- Admin Controls for Topic -->
                    @if(auth()->user()->isAdmin() && $editingTopicId !== $topic->id)
                        <div class="flex gap-2 ml-4">
                            <button wire:click="startEditTopic"
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Edit
                            </button>
                            <button wire:click="deleteTopic"
                                    onclick="return confirm('Delete this entire topic and all its posts?')"
                                    class="text-red-600 hover:text-red-800 text-sm font-medium">
                                Delete
                            </button>
                        </div>
                    @endif
                </div>

                @if($editingTopicId !== $topic->id)
                    <!-- Topic Content -->
                    <div class="mt-4 text-gray-800 prose max-w-none">
                        {{ $topic->content }}
                    </div>
                @endif
            </div>

            <!-- Posts/Replies -->
            <div class="divide-y divide-gray-200">
                @forelse($posts as $post)
                    <div class="p-6">
                        <div class="flex space-x-4">
                            <!-- User Avatar -->
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-indigo-500 flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                </div>
                            </div>

                            <!-- Post Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-baseline justify-between">
                                    <div class="flex items-baseline space-x-2">
                                        <span class="font-semibold text-gray-900">{{ $post->user->name }}</span>
                                        <span class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
                                        @if($post->is_edited)
                                            <span class="text-xs text-gray-400">(edited {{ $post->edited_at?->diffForHumans() }})</span>
                                        @endif
                                    </div>

                                    <!-- Admin Controls for Post -->
                                    @if(auth()->user()->isAdmin())
                                        <div class="text-xs space-x-2">
                                            @if($editingPostId === $post->id)
                                                <button wire:click="saveEditPost({{ $post->id }})"
                                                        class="text-green-600 hover:text-green-800 font-medium">
                                                    Save
                                                </button>
                                                <button wire:click="cancelEditPost"
                                                        class="text-gray-600 hover:text-gray-800 font-medium">
                                                    Cancel
                                                </button>
                                            @else
                                                <button wire:click="startEditPost({{ $post->id }}, '{{ addslashes($post->content) }}')"
                                                        class="text-blue-600 hover:text-blue-800 font-medium">
                                                    Edit
                                                </button>
                                                <button wire:click="deletePost({{ $post->id }})"
                                                        onclick="return confirm('Delete this post?')"
                                                        class="text-red-600 hover:text-red-800 font-medium">
                                                    Delete
                                                </button>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <!-- Reply Context -->
                                @if($post->replyTo)
                                    <div class="mt-2 pl-3 border-l-2 border-gray-300 text-sm text-gray-600">
                                        <span class="font-medium">@{{ $post->replyTo->user->name }}</span>
                                        <span class="text-gray-500">{{ Str::limit($post->replyTo->content, 50) }}</span>
                                    </div>
                                @endif

                                <!-- Post Text or Edit Form -->
                                @if($editingPostId === $post->id)
                                    <div class="mt-2">
                                        <textarea wire:model="editPostContent"
                                                  class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                                  rows="4"></textarea>
                                    </div>
                                @else
                                    <div class="mt-2 text-gray-800 break-words">
                                        {{ $post->content }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500">
                        No replies yet. Be the first to respond!
                    </div>
                @endforelse
            </div>

            <!-- Add Reply Form -->
            @if(!$topic->is_locked)
                <div class="p-6 bg-gray-50 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Add a Reply</h3>
                    <form wire:submit.prevent="addPost">
                        <textarea wire:model="newPostContent"
                                  rows="4"
                                  class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                  placeholder="Write your reply..."></textarea>
                        @error('newPostContent')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <div class="mt-4">
                            <button type="submit"
                                    class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-semibold">
                                Post Reply
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="p-6 bg-yellow-50 border-t border-yellow-200 text-center">
                    <p class="text-yellow-800 font-medium">This topic is locked. No new replies can be added.</p>
                </div>
            @endif
        </div>

        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('forums') }}"
               class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Forums
            </a>
        </div>
    </div>
</div>
</x-app-layout>
