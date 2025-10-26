<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Send Notification
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.notifications.store') }}">
                        @csrf

                        <!-- Title -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Title *
                            </label>
                            <input type="text" name="title" id="title" required
                                value="{{ old('title') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="e.g., New Feature Announcement">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Message -->
                        <div class="mb-6">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                Message *
                            </label>
                            <textarea name="message" id="message" rows="4" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Write your notification message here...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Priority -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Priority *
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 {{ old('priority') === 'info' || !old('priority') ? 'border-blue-500 bg-blue-50' : 'border-gray-300' }}">
                                    <input type="radio" name="priority" value="info" checked
                                        class="text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm">
                                        <span class="block font-medium text-blue-600">Info</span>
                                        <span class="text-xs text-gray-500">General information</span>
                                    </span>
                                </label>
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 {{ old('priority') === 'success' ? 'border-green-500 bg-green-50' : 'border-gray-300' }}">
                                    <input type="radio" name="priority" value="success"
                                        class="text-green-600 focus:ring-green-500">
                                    <span class="ml-2 text-sm">
                                        <span class="block font-medium text-green-600">Success</span>
                                        <span class="text-xs text-gray-500">Good news</span>
                                    </span>
                                </label>
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 {{ old('priority') === 'warning' ? 'border-yellow-500 bg-yellow-50' : 'border-gray-300' }}">
                                    <input type="radio" name="priority" value="warning"
                                        class="text-yellow-600 focus:ring-yellow-500">
                                    <span class="ml-2 text-sm">
                                        <span class="block font-medium text-yellow-600">Warning</span>
                                        <span class="text-xs text-gray-500">Needs attention</span>
                                    </span>
                                </label>
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 {{ old('priority') === 'error' ? 'border-red-500 bg-red-50' : 'border-gray-300' }}">
                                    <input type="radio" name="priority" value="error"
                                        class="text-red-600 focus:ring-red-500">
                                    <span class="ml-2 text-sm">
                                        <span class="block font-medium text-red-600">Error</span>
                                        <span class="text-xs text-gray-500">Critical issue</span>
                                    </span>
                                </label>
                            </div>
                            @error('priority')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Recipients -->
                        <div class="mb-6">
                            <label for="recipients" class="block text-sm font-medium text-gray-700 mb-2">
                                Send To *
                            </label>
                            <select name="recipients" id="recipients" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="all" {{ old('recipients') === 'all' ? 'selected' : '' }}>All Users</option>
                                <option value="admin" {{ old('recipients') === 'admin' ? 'selected' : '' }}>Admins Only</option>
                                <option value="paid_member" {{ old('recipients') === 'paid_member' ? 'selected' : '' }}>Paid Members Only</option>
                                <option value="free_member" {{ old('recipients') === 'free_member' ? 'selected' : '' }}>Free Members Only</option>
                            </select>
                            @error('recipients')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action URL (Optional) -->
                        <div class="mb-6">
                            <label for="action_url" class="block text-sm font-medium text-gray-700 mb-2">
                                Action URL (Optional)
                            </label>
                            <input type="url" name="action_url" id="action_url"
                                value="{{ old('action_url') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="https://example.com or {{ route('dashboard') }}">
                            <p class="mt-1 text-sm text-gray-500">Link users can click in the notification</p>
                            @error('action_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Text (Optional) -->
                        <div class="mb-6">
                            <label for="action_text" class="block text-sm font-medium text-gray-700 mb-2">
                                Action Button Text (Optional)
                            </label>
                            <input type="text" name="action_text" id="action_text"
                                value="{{ old('action_text') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="e.g., View Details, Learn More">
                            @error('action_text')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end gap-3 mt-8">
                            <a href="{{ route('dashboard') }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
                                Send Notification
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Preview Section -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Preview</h3>
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <p class="text-sm text-gray-500 mb-2">How your notification will look:</p>
                        <div class="bg-white border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <svg class="h-6 w-6 text-blue-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">Your Title Here</h4>
                                    <p class="text-sm text-gray-700 mt-1">Your message will appear here...</p>
                                    <div class="mt-2 flex items-center gap-2">
                                        <span class="text-xs text-gray-500">Just now</span>
                                        <button class="text-xs font-medium text-indigo-600">Your Action Text →</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
