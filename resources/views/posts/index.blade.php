<x-app-layout>
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
                    {{ $post->community->name }}
                    &middot;
                    {{ $post->user->name }}
                </p>

                <h2 class="text-xl font-semibold">
                    {{ $post->title }}
                </h2>

                <p class="mt-2">
                    {{ $post->body }}
                </p>
            </article>
        @empty
            <p>No posts yet.</p>
        @endforelse
    </div>
</x-app-layout>
