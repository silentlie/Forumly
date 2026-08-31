<x-app-layout>
    @if (session('success'))
        <p class="mb-4 text-green-600">
            {{ session('success') }}
        </p>
    @endif

    @if (session('error'))
        <p class="mb-4 text-red-600">
            {{ session('error') }}
        </p>
    @endif
    <div class="max-w-3xl mx-auto py-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold">Communities</h1>
                <p class="mt-1 text-gray-600">
                    Browse Forumly communities.
                </p>
            </div>

            @auth
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.communities.create') }}" class="rounded bg-gray-900 px-4 py-2 text-white">
                        Create Community
                    </a>
                @endif
            @endauth
        </div>

        @forelse ($communities as $community)
            <article class="border rounded-lg p-4 mb-4">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-semibold">
                            <a href="{{ route('communities.show', $community) }}">
                                {{ $community->name }}
                            </a>
                        </h2>

                        @if ($community->description)
                            <p class="mt-2">
                                {{ $community->description }}
                            </p>
                        @endif

                        <p class="mt-2 text-sm text-gray-500">
                            {{ $community->posts_count }}
                            {{ Str::plural('post', $community->posts_count) }}
                        </p>
                    </div>

                    @auth
                        @if (auth()->user()->isAdmin())
                            <div class="flex gap-3">
                                <a href="{{ route('admin.communities.edit', $community) }}" class="text-blue-600">
                                    Edit
                                </a>

                                <form method="POST" action="{{ route('admin.communities.destroy', $community) }}"
                                    onsubmit="return confirm('Delete this community?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-600">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </article>
        @empty
            <p>No communities yet.</p>
        @endforelse
    </div>
</x-app-layout>
