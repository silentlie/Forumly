<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">
        <a href="{{ route('posts.index') }}">
            ← Back
        </a>

        <article class="border rounded-lg p-4 mt-4">
            <p class="text-sm">
                <a href="{{ route('communities.show', $post->community) }}">
                    {{ $post->community->name }}
                </a>
                &middot;
                {{ $post->user->name }}
            </p>

            <h1 class="text-2xl font-bold mt-2">
                {{ $post->title }}
            </h1>

            <p class="mt-4">
                {{ $post->body }}
            </p>

            @if (!empty($post->file_paths))
                <div class="mt-6">
                    <h2 class="font-semibold">Attachments</h2>

                    <ul>
                        @foreach ($post->file_paths as $index => $file)
                            <li>
                                <a href="{{ route('posts.files.download', [$post, $index]) }}">
                                    {{ $file['name'] }}
                                </a>

                                <span class="text-sm text-gray-500">
                                    ({{ number_format($file['size'] / 1024, 1) }} KB)
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

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

            <div class="mt-4">
                @auth
                    <button type="button"
                        class="vote-button {{ $post->voters->contains('id', auth()->id()) ? 'font-bold' : '' }}"
                        data-url="{{ route('posts.vote', $post) }}">
                        ▲
                        <span class="vote-count">
                            {{ $post->voters->count() }}
                        </span>
                    </button>
                @else
                    <span>
                        ▲ {{ $post->voters->count() }}
                    </span>
                @endauth
            </div>
        </article>

        <section class="mt-8">
            <h2 class="text-xl font-bold mb-4">
                Comments
            </h2>

            @auth
                <form method="POST" action="{{ route('comments.store', $post) }}" class="mb-6">
                    @csrf

                    <textarea name="body" rows="4" class="w-full border rounded-lg p-3" placeholder="Write a comment...">{{ old('body') }}</textarea>

                    @error('body')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                    <button type="submit" class="mt-2">
                        Comment
                    </button>
                </form>
            @else
                <p class="mb-6">
                    Please log in to comment.
                </p>
            @endauth

            @forelse ($post->comments as $comment)
                <article class="border rounded-lg p-4 mb-3">
                    <div class="text-sm text-gray-500">
                        {{ $comment->user->name }}
                        &middot;
                        {{ $comment->created_at->diffForHumans() }}
                    </div>

                    <p class="mt-2">
                        {{ $comment->body }}
                    </p>
                </article>
            @empty
                <p>No comments yet.</p>
            @endforelse
        </section>
    </div>
</x-app-layout>
