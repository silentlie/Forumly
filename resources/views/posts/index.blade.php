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
            <article
                class="mb-5 rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition duration-200 hover:border-gray-300 hover:shadow-md">
                {{-- Top row --}}
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <a href="{{ route('communities.show', $post->community) }}"
                            class="text-sm font-medium text-gray-600
                        transition hover:text-gray-900 hover:underline
                        underline-offset-2">
                            {{ $post->community->name }}
                        </a>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ $post->user->name }}

                            <span class="mx-1">&middot;</span>

                            {{ $post->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <x-vote-button :post="$post" :count="$post->voters_count" :voted="$post->has_voted ?? false" />
                </div>

                {{-- Post content --}}
                <div class="mt-3">
                    <h2 class="text-xl font-semibold text-gray-900">
                        <a href="{{ route('posts.show', $post) }}"
                            class="transition hover:text-gray-600 hover:underline
                        decoration-2 underline-offset-4">
                            {{ $post->title }}
                        </a>
                    </h2>

                    <p class="mt-2 leading-relaxed text-gray-700">
                        {{ $post->body }}
                    </p>
                </div>
            </article>
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
