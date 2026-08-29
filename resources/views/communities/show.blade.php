<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">
        <div class="mb-6">
            <a href="{{ route('posts.index') }}">
                ← Back to posts
            </a>

            <h1 class="text-2xl font-bold mt-4">
                {{ $community->name }}
            </h1>

            @if ($community->description)
                <p class="mt-2">
                    {{ $community->description }}
                </p>
            @endif
        </div>

        @forelse ($posts as $post)
            <article class="border rounded-lg p-4 mb-4">
                <p class="text-sm">
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
            <p>No posts in this community yet.</p>
        @endforelse

        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
