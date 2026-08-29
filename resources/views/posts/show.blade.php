<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">
        <a href="{{ route('posts.index') }}">
            ← Back
        </a>

        <article class="border rounded-lg p-4 mt-4">
            <p class="text-sm">
                {{ $post->community->name }}
                &middot;
                {{ $post->user->name }}
            </p>

            <h1 class="text-2xl font-bold mt-2">
                {{ $post->title }}
            </h1>

            <p class="mt-4">
                {{ $post->body }}
            </p>
            {{-- TODO: add file attachments --}}
            <div class="flex gap-4 mt-6">
                @can('update', $post)
                    <a href="{{ route('posts.edit', $post) }}">
                        Edit
                    </a>
                @endcan

                @can('delete', $post)
                    <form method="POST" action="{{ route('posts.destroy', $post) }}">
                        @csrf
                        @method('DELETE')

                        <button type="submit">
                            Delete
                        </button>
                    </form>
                @endcan
            </div>
        </article>
    </div>
</x-app-layout>
