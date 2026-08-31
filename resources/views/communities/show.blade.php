<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">
        <div class="mb-6">
            <a href="{{ route('communities.index') }}">
                ← Back to communities
            </a>

            <div class="mt-4 flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold">
                        {{ $community->name }}
                    </h1>

                    @if ($community->description)
                        <p class="mt-2 text-gray-600">
                            {{ $community->description }}
                        </p>
                    @endif
                </div>

                @auth
                    @if (auth()->user()->isAdmin())
                        <div class="flex gap-3">
                            <a href="{{ route('admin.communities.edit', $community) }}"
                                class="rounded bg-gray-900 px-4 py-2 text-white">
                                Edit
                            </a>

                            <form method="POST" action="{{ route('admin.communities.destroy', $community) }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="rounded bg-red-600 px-4 py-2 text-white"
                                    onclick="return confirm('Delete this community?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        </div>

        <div class="mb-4">
            <h2 class="text-xl font-semibold">
                Posts
            </h2>
        </div>

        @forelse ($posts as $post)
            <article class="mb-4 rounded-lg border p-4">
                <p class="text-sm text-gray-500">
                    {{ $post->user->name }}
                </p>

                <h3 class="text-xl font-semibold">
                    <a href="{{ route('posts.show', $post) }}">
                        {{ $post->title }}
                    </a>
                </h3>

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
