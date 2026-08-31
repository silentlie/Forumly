<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row">
            <form method="GET" action="{{ route('posts.index') }}" class="flex min-w-0 flex-1 gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search posts, users or communities..."
                    class="min-w-0 flex-1 rounded-lg border border-gray-300 bg-white px-3 py-2
                shadow-sm transition
                focus:border-gray-500 focus:ring-gray-500">

                <button type="submit"
                    class="cursor-pointer rounded-lg border border-gray-300 bg-white px-4 py-2
                text-sm font-semibold text-gray-700 shadow-sm transition
                hover:bg-gray-50 hover:text-gray-900
                active:bg-gray-100">
                    Search
                </button>
            </form>

            @auth
                <a href="{{ route('posts.create') }}"
                    class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2
                text-sm font-semibold text-white shadow-sm transition
                hover:bg-gray-700 active:bg-gray-950">
                    <span class="me-1 text-lg leading-none">+</span>
                    Create Post
                </a>
            @endauth
        </div>

        @if (session('success'))
            <p class="mb-4">
                {{ session('success') }}
            </p>
        @endif

        @forelse ($posts as $post)
            <x-post-card :post="$post" class="mb-5" />
        @empty
            @if (request('search'))
                <p>
                    No results found for "{{ request('search') }}".
                </p>
            @else
                <p>No posts yet.</p>
            @endif
        @endforelse

        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
