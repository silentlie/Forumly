<x-app-layout>
    <form method="GET" action="{{ route('posts.index') }}" class="mb-6 flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search posts..."
            class="border rounded px-3 py-2 flex-1">

        <select name="community" class="border rounded px-3 py-2">
            <option value="">All communities</option>

            @foreach ($communities as $community)
                <option value="{{ $community->id }}" @selected(request('community') == $community->id)>
                    {{ $community->name }}
                </option>
            @endforeach
        </select>

        <button type="submit">
            Search
        </button>
    </form>
    <div class="max-w-3xl mx-auto py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Forumly</h1>

            @auth
                <a href="{{ route('posts.create') }}">
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
            <article class="border rounded-lg p-4 mb-4">
                <p class="text-sm">
                    <a href="{{ route('communities.show', $post->community) }}">
                        {{ $post->community->name }}
                    </a>
                    &middot;
                    {{ $post->user->name }}
                </p>

                <h2 class="text-xl font-semibold">
                    <a href="{{ route('posts.show', $post) }}">
                        {{ $post->title }}
                    </a>
                </h2>

                <p class="mt-2">
                    {{ $post->body }}
                </p>
            </article>
        @empty
            <p>No posts yet.</p>
        @endforelse
        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
