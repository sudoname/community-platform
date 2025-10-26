<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create New Forum Topic
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($categories->isEmpty())
                        <div class="bg-yellow-50 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
                            <p class="font-bold">No Categories Available</p>
                            <p>You need to create forum categories before creating topics. Please create categories first.</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.forums.store') }}">
                        @csrf

                        <!-- Category -->
                        <div class="mb-6">
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Category *
                            </label>
                            <select name="category_id" id="category_id" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                {{ $categories->isEmpty() ? 'disabled' : '' }}>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                value="{{ old('title') }}"
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
                                placeholder="Write your forum topic content here...">{{ old('content') }}</textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pin Topic -->
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_pinned" value="1"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700">Pin this topic to the top</span>
                            </label>
                            <p class="mt-1 text-sm text-gray-500">Pinned topics appear at the top of the forum</p>
                        </div>

                        <!-- Role-Based Visibility -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Who Can See This Topic? *
                            </label>
                            <div class="space-y-3 bg-gray-50 p-4 rounded-lg">
                                <label class="flex items-center">
                                    <input type="checkbox" name="allowed_roles[]" value="admin" checked
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm font-medium text-gray-700">Admins</span>
                                    <span class="ml-2 text-xs text-gray-500">(Full platform access)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="allowed_roles[]" value="paid_member" checked
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm font-medium text-gray-700">Paid Members</span>
                                    <span class="ml-2 text-xs text-gray-500">(Premium subscribers)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="allowed_roles[]" value="free_member" checked
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm font-medium text-gray-700">Free Members</span>
                                    <span class="ml-2 text-xs text-gray-500">(Basic access)</span>
                                </label>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Select which user roles can access this topic</p>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end gap-3 mt-8">
                            <a href="{{ route('dashboard') }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700"
                                {{ $categories->isEmpty() ? 'disabled' : '' }}>
                                Create Topic
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
