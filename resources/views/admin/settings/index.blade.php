<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Site Settings
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                ← Back to Admin
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Configure Site Settings</h3>

                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            @foreach($settings as $setting)
                                <div class="border-b border-gray-200 pb-6 last:border-0">
                                    @if($setting->type === 'text')
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                                        </label>
                                        <input type="text"
                                               name="settings[{{ $setting->key }}]"
                                               value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                               class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">

                                    @elseif($setting->type === 'textarea')
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                                        </label>
                                        <textarea name="settings[{{ $setting->key }}]"
                                                  rows="4"
                                                  class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('settings.' . $setting->key, $setting->value) }}</textarea>

                                    @elseif($setting->type === 'boolean')
                                        <div class="flex items-center">
                                            <input type="checkbox"
                                                   name="settings[{{ $setting->key }}]"
                                                   value="1"
                                                   {{ old('settings.' . $setting->key, $setting->value) == '1' ? 'checked' : '' }}
                                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                            <label class="ml-2 block text-sm font-medium text-gray-700">
                                                {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                                            </label>
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500">
                                            @if($setting->key === 'maintenance_mode')
                                                Enable maintenance mode to temporarily disable the site for users
                                            @elseif($setting->key === 'allow_registrations')
                                                Allow new users to register on the site
                                            @endif
                                        </p>

                                    @elseif($setting->type === 'number')
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                                        </label>
                                        <input type="number"
                                               name="settings[{{ $setting->key }}]"
                                               value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                               class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8 flex justify-end space-x-4">
                            <a href="{{ route('admin.dashboard') }}"
                               class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-semibold">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-semibold">
                                Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Info Panel -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h4 class="text-sm font-semibold text-blue-900 mb-2">About Site Settings</h4>
                <p class="text-sm text-blue-800">
                    These settings control various aspects of your investment community platform. Changes take effect immediately after saving.
                </p>
                <ul class="mt-3 space-y-1 text-sm text-blue-800">
                    <li>• <strong>Site Name:</strong> Displayed in browser title and navigation</li>
                    <li>• <strong>Site Description:</strong> Used for SEO and social media sharing</li>
                    <li>• <strong>Contact Email:</strong> Primary admin contact for the site</li>
                    <li>• <strong>Maintenance Mode:</strong> Temporarily disable site access for non-admins</li>
                    <li>• <strong>Allow Registrations:</strong> Enable or disable new user signups</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
