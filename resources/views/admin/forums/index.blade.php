<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manage Forum Topics
            </h2>
            <a href="{{ route('admin.forums.create') }}"
                class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700">
                + New Topic
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Topic
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Category
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Author
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Allowed Roles
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Stats
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($topics as $topic)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900 flex items-center gap-2">
                                                        @if($topic->is_pinned)
                                                            <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L11 4.323V3a1 1 0 011-1zm-5 8.274l-.818 2.552c-.25.78.146 1.638.918 1.979l.598.264a.75.75 0 01.424.756v1.917a1.5 1.5 0 001.5 1.5h3.126a1.5 1.5 0 001.5-1.5v-1.917a.75.75 0 01.424-.756l.598-.264c.772-.341 1.168-1.199.918-1.979L13.37 10.274 11 9.051 8.63 10.274z"/>
                                                            </svg>
                                                        @endif
                                                        {{ Str::limit($topic->title, 50) }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $topic->last_activity_at?->diffForHumans() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-900">{{ $topic->category->name }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-900">{{ $topic->user->name }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-1">
                                                @php
                                                    $roles = $topic->allowed_roles;
                                                    if (is_string($roles)) {
                                                        $roles = json_decode($roles, true);
                                                    }
                                                @endphp
                                                @if($roles && is_array($roles) && count($roles) > 0)
                                                    @foreach($roles as $role)
                                                        <span class="px-2 py-1 text-xs font-semibold rounded bg-purple-100 text-purple-800">
                                                            {{ ucfirst(str_replace('_', ' ', $role)) }}
                                                        </span>
                                                    @endforeach
                                                @else
                                                    <span class="text-xs text-gray-500">All roles</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex flex-col">
                                                <span>{{ $topic->views_count }} views</span>
                                                <span>{{ $topic->replies_count }} replies</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($topic->is_locked)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Locked
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Open
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.forums.edit', $topic) }}"
                                                class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.forums.destroy', $topic) }}"
                                                method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this topic and all its posts?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                            No forum topics found. Create your first topic!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($topics->hasPages())
                        <div class="mt-6">
                            {{ $topics->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
