<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Forum Topic: {{ $forum->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.forums.update', $forum) }}">
                        @csrf
                        @method('PUT')

                        <!-- Category -->
                        <div class="mb-6">
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Category *
                            </label>
                            <select name="category_id" id="category_id" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $forum->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Topic Title -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Topic Title *
                            </label>
                            <input type="text" name="title" id="title" required
                                value="{{ old('title', $forum->title) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="e.g., Welcome to the Community">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div class="mb-6">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                Content *
                            </label>
                            <textarea name="content" id="content" rows="8" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Write your forum topic content here...">{{ old('content', $forum->content) }}</textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pin Topic -->
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_pinned" value="1"
                                    {{ old('is_pinned', $forum->is_pinned) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700">Pin this topic to the top</span>
                            </label>
                            <p class="mt-1 text-sm text-gray-500">Pinned topics appear at the top of the forum</p>
                        </div>

                        <!-- Lock Topic -->
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_locked" value="1"
                                    {{ old('is_locked', $forum->is_locked) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700">Lock this topic</span>
                            </label>
                            <p class="mt-1 text-sm text-gray-500">Locked topics cannot receive new replies</p>
                        </div>

                        <!-- Role-Based Visibility -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Who Can See This Topic? *
                            </label>
                            <div class="space-y-3 bg-gray-50 p-4 rounded-lg">
                                <label class="flex items-center">
                                    <input type="checkbox" name="allowed_roles[]" value="admin"
                                        {{ in_array('admin', old('allowed_roles', $forum->allowed_roles ?? [])) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm font-medium text-gray-700">Admins</span>
                                    <span class="ml-2 text-xs text-gray-500">(Full platform access)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="allowed_roles[]" value="paid_member"
                                        {{ in_array('paid_member', old('allowed_roles', $forum->allowed_roles ?? [])) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm font-medium text-gray-700">Paid Members</span>
                                    <span class="ml-2 text-xs text-gray-500">(Premium subscribers)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="allowed_roles[]" value="free_member"
                                        {{ in_array('free_member', old('allowed_roles', $forum->allowed_roles ?? [])) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm font-medium text-gray-700">Free Members</span>
                                    <span class="ml-2 text-xs text-gray-500">(Basic access)</span>
                                </label>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Select which user roles can access this topic</p>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end gap-3 mt-8">
                            <a href="{{ route('admin.forums.index') }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                                Update Topic
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
