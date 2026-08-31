<x-app-layout>

    {{-- Header --}}
    <div class="mb-6 flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Communities
            </h1>

            <p class="mt-1 text-gray-600">
                Browse Forumly communities.
            </p>
        </div>

        @auth
            @if (auth()->user()->isAdmin())
                <a href="{{ route('admin.communities.create') }}"
                    class="inline-flex items-center justify-center rounded-lg
                            bg-gray-900 px-4 py-2
                            text-sm font-semibold text-white
                            shadow-sm transition
                            hover:bg-gray-700
                            active:bg-gray-950">
                    <x-heroicon-o-plus class="h-4 w-4" />
                    Create Community
                </a>
            @endif
        @endauth
    </div>

    {{-- Communities --}}
    <div class="space-y-5">
        @forelse ($communities as $community)
            <article
                class="rounded-xl border border-gray-200 bg-white p-6
                        shadow-sm transition duration-200
                        hover:border-gray-300 hover:shadow-md">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <h2 class="text-xl font-semibold text-gray-900">
                            <a href="{{ route('communities.show', $community) }}"
                                class="transition
                                        hover:text-gray-600 hover:underline
                                        decoration-2 underline-offset-4">
                                {{ $community->name }}
                            </a>
                        </h2>

                        @if ($community->description)
                            <p class="mt-2 leading-relaxed text-gray-700">
                                {{ $community->description }}
                            </p>
                        @endif

                        <p class="mt-3 text-sm text-gray-500">
                            {{ $community->posts_count }}
                            {{ Str::plural('post', $community->posts_count) }}
                        </p>
                    </div>

                    @auth
                        @if (auth()->user()->isAdmin())
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button type="button" aria-label="Community actions"
                                        class="inline-flex h-9 w-9 shrink-0
                                                cursor-pointer items-center justify-center
                                                rounded-full border border-gray-300
                                                bg-gray-100
                                                text-gray-600 shadow-sm transition
                                                hover:border-gray-400
                                                hover:bg-gray-200
                                                hover:text-gray-900
                                                active:scale-95">
                                        <x-heroicon-o-ellipsis-horizontal class="h-5 w-5" />
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('admin.communities.edit', $community)">
                                        Edit
                                    </x-dropdown-link>

                                    <form method="POST" action="{{ route('admin.communities.destroy', $community) }}"
                                        onsubmit="return confirm('Delete this community?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="block w-full px-4 py-2
                                                    text-start text-sm leading-5
                                                    text-red-600 transition
                                                    hover:bg-gray-100
                                                    focus:bg-gray-100
                                                    focus:outline-none">
                                            Delete
                                        </button>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        @endif
                    @endauth
                </div>
            </article>
        @empty
            <div class="rounded-xl border border-gray-200 bg-white
                        p-6 text-gray-500 shadow-sm">
                No communities yet.
            </div>
        @endforelse
    </div>
</x-app-layout>
