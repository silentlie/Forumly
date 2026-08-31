<x-app-layout>
    {{-- Community header --}}
    <div class="mb-4 flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                {{ $community->name }}
            </h1>

            @if ($community->description)
                <p class="mt-2 text-gray-600">
                    {{ $community->description }}
                </p>
            @endif
        </div>


        @auth


            <div class="flex flex-wrap items-center justify-end gap-2">
                <a href="{{ route('communities.posts.create', $community) }}"
                    class="inline-flex items-center justify-center rounded-lg  bg-gray-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-700 active:bg-gray-950">
                    <x-heroicon-o-plus class="h-4 w-4" />
                    Create Post
                </a>
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.communities.edit', $community) }}"
                        class="rounded-lg border border-gray-300 bg-white
                                px-3 py-2 text-sm font-semibold text-gray-700
                                shadow-sm transition
                                hover:bg-gray-100 hover:text-gray-900">
                        Edit
                    </a>

                    <form method="POST" action="{{ route('admin.communities.destroy', $community) }}"
                        onsubmit="return confirm('Delete this community?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="cursor-pointer rounded-lg border border-red-200
                                    bg-white px-3 py-2 text-sm font-semibold
                                    text-red-600 shadow-sm transition
                                    hover:border-red-300 hover:bg-red-50
                                    hover:text-red-700">
                            Delete
                        </button>
                    </form>
                @endif
            </div>
        @endauth
    </div>

    @forelse ($posts as $post)
        <x-post-card :post="$post" class="mb-5" />
    @empty
        <div class="rounded-xl border border-gray-200 bg-white
                    p-6 text-gray-500 shadow-sm">
            No posts in this community yet.
        </div>
    @endforelse

    <div class="mt-6">
        {{ $posts->links() }}
    </div>
</x-app-layout>
