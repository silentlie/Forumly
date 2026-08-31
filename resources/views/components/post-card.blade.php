@props(['post'])

<article
    {{ $attributes->class([
        'rounded-xl border border-gray-200 bg-white p-6 shadow-sm',
        'transition duration-200 hover:border-gray-300 hover:shadow-md',
    ]) }}>
    {{-- Top row --}}
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <a href="{{ route('communities.show', $post->community) }}"
                class="inline-flex items-center rounded-full
        border border-gray-200 bg-gray-100
        px-2 py-0.5
        text-sm font-medium text-gray-700
        transition
        hover:border-gray-300 hover:bg-gray-200
        hover:text-gray-900">
                {{ $post->community->name }}
            </a>

            <p class="mt-1 text-sm text-gray-500">
                {{ $post->user->name }}

                <span class="mx-1">&middot;</span>

                {{ $post->created_at->diffForHumans() }}
            </p>
        </div>

        <div class="flex shrink-0 items-center gap-2">
            <x-vote-button :post="$post" :count="$post->voters_count" :voted="$post->has_voted ?? false" />

            @canany(['update', 'delete'], $post)
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button type="button" aria-label="Post actions"
                            class="inline-flex h-9 w-9 items-center justify-center
        rounded-full border border-gray-300 bg-gray-100
        text-gray-600 transition
        hover:border-gray-400 hover:bg-gray-200">
                            <x-heroicon-o-ellipsis-horizontal class="h-5 w-5" />
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @can('update', $post)
                            <x-dropdown-link :href="route('posts.edit', $post)">
                                Edit
                            </x-dropdown-link>
                        @endcan

                        @can('delete', $post)
                            <form method="POST" action="{{ route('posts.destroy', $post) }}"
                                onsubmit="return confirm('Delete this post?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="block w-full px-4 py-2 text-start
                                        text-sm leading-5 text-red-600
                                        transition duration-150 ease-in-out
                                        hover:bg-gray-100
                                        focus:bg-gray-100 focus:outline-none">
                                    Delete
                                </button>
                            </form>
                        @endcan
                    </x-slot>
                </x-dropdown>
            @endcanany
        </div>
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

    @if (!empty($post->file_paths))
        <div class="mt-5 border-t border-gray-200 pt-4">
            <p class="text-sm font-medium text-gray-600">
                Attachments
            </p>

            <div class="mt-2 flex flex-wrap gap-2">
                @foreach ($post->file_paths as $index => $file)
                    <a href="{{ route('posts.files.download', [$post, $index]) }}"
                        class="inline-flex max-w-full items-center gap-1.5
        rounded-full border border-gray-200
        bg-gray-50 px-2.5 py-1
        text-sm text-gray-700
        transition
        hover:border-gray-300
        hover:bg-gray-100
        hover:text-gray-900">
                        <span class="max-w-48 truncate font-medium">
                            {{ $file['name'] }}
                        </span>

                        <span class="text-xs text-gray-500">
                            {{ number_format($file['size'] / 1024, 1) }} KB
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</article>
