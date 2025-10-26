<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Channel: {{ $channel->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.channels.update', $channel) }}">
                        @csrf
                        @method('PUT')

                        <!-- Channel Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Channel Name *
                            </label>
                            <input type="text" name="name" id="name" required
                                value="{{ old('name', $channel->name) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="e.g., general-chat">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description
                            </label>
                            <textarea name="description" id="description" rows="3"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="What is this channel for?">{{ old('description', $channel->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Channel Type -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Channel Type *
                            </label>
                            <div class="space-y-2">
                                <label class="inline-flex items-center mr-6">
                                    <input type="radio" name="type" value="text"
                                        {{ old('type', $channel->type) === 'text' ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-700">Text Channel</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="type" value="announcement"
                                        {{ old('type', $channel->type) === 'announcement' ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-700">Announcement Channel</span>
                                </label>
                            </div>
                        </div>

                        <!-- Privacy -->
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_private" value="1"
                                    {{ old('is_private', $channel->is_private) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700">Make this channel private</span>
                            </label>
                        </div>

                        <!-- Active Status -->
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1"
                                    {{ old('is_active', $channel->is_active ?? true) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700">Channel is active</span>
                            </label>
                            <p class="mt-1 text-sm text-gray-500">Inactive channels are hidden from all users</p>
                        </div>

                        <!-- Role-Based Visibility -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Who Can See This Channel? *
                            </label>
                            <div class="space-y-3 bg-gray-50 p-4 rounded-lg">
                                <label class="flex items-center">
                                    <input type="checkbox" name="allowed_roles[]" value="admin"
                                        {{ in_array('admin', old('allowed_roles', $channel->allowed_roles ?? [])) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm font-medium text-gray-700">Admins</span>
                                    <span class="ml-2 text-xs text-gray-500">(Full platform access)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="allowed_roles[]" value="paid_member"
                                        {{ in_array('paid_member', old('allowed_roles', $channel->allowed_roles ?? [])) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm font-medium text-gray-700">Paid Members</span>
                                    <span class="ml-2 text-xs text-gray-500">(Premium subscribers)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="allowed_roles[]" value="free_member"
                                        {{ in_array('free_member', old('allowed_roles', $channel->allowed_roles ?? [])) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm font-medium text-gray-700">Free Members</span>
                                    <span class="ml-2 text-xs text-gray-500">(Basic access)</span>
                                </label>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Select which user roles can access this channel</p>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end gap-3 mt-8">
                            <a href="{{ route('admin.channels.index') }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                Update Channel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
