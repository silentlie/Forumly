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
        </article>
    </div>
</x-app-layout>
