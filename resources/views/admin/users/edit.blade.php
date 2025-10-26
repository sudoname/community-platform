<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit User: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                            <select name="role" id="role"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required onchange="toggleExpirationField()">
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="paid_member" {{ old('role', $user->role) === 'paid_member' ? 'selected' : '' }}>Paid Member</option>
                                <option value="free_member" {{ old('role', $user->role) === 'free_member' ? 'selected' : '' }}>Free Member</option>
                            </select>
                        </div>

                        <div class="mb-4" id="expiration-field" style="display: {{ old('role', $user->role) === 'paid_member' ? 'block' : 'none' }};">
                            <label for="paid_expiration" class="block text-sm font-medium text-gray-700">
                                Paid Member Expiration Date
                                <span class="text-gray-500 text-xs">(optional - user will auto-downgrade to free after this date)</span>
                            </label>
                            <input type="datetime-local" name="paid_expiration" id="paid_expiration"
                                value="{{ old('paid_expiration', $user->paid_expiration ? \Carbon\Carbon::parse($user->paid_expiration)->format('Y-m-d\TH:i') : '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @if($user->paid_expiration)
                                <p class="mt-1 text-sm text-gray-600">
                                    Current expiration: {{ \Carbon\Carbon::parse($user->paid_expiration)->format('M d, Y g:i A') }}
                                    @if($user->paid_expiration < now())
                                        <span class="text-red-600 font-semibold">(Expired)</span>
                                    @endif
                                </p>
                            @endif
                        </div>

                        <div class="mb-4">
                            <div class="bg-gray-50 p-4 rounded-md">
                                <h3 class="text-sm font-medium text-gray-700 mb-2">User Information</h3>
                                <p class="text-sm text-gray-600">Member since: {{ $user->created_at->format('M d, Y') }}</p>
                                <p class="text-sm text-gray-600">Last updated: {{ $user->updated_at->format('M d, Y g:i A') }}</p>
                                @if($user->email_verified_at)
                                    <p class="text-sm text-gray-600">Email verified: {{ \Carbon\Carbon::parse($user->email_verified_at)->format('M d, Y') }}</p>
                                @else
                                    <p class="text-sm text-red-600">Email not verified</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('admin.users.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleExpirationField() {
            const role = document.getElementById('role').value;
            const expirationField = document.getElementById('expiration-field');
            if (role === 'paid_member') {
                expirationField.style.display = 'block';
            } else {
                expirationField.style.display = 'none';
            }
        }
    </script>
</x-app-layout>
