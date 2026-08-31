@props(['post', 'count' => 0, 'voted' => false])

@auth
    <button type="button" data-url="{{ route('posts.vote', $post) }}" aria-pressed="{{ $voted ? 'true' : 'false' }}"
        aria-label="Upvote post"
        class="vote-button inline-flex shrink-0 cursor-pointer items-center gap-1.5
            rounded-full border border-gray-300 bg-gray-100
            px-3 py-1.5
            text-sm font-semibold text-gray-700
            shadow-sm transition duration-150

            hover:border-gray-400 hover:bg-gray-200
            hover:text-gray-950 hover:shadow

            active:scale-95

            focus-visible:outline-none
            focus-visible:ring-2
            focus-visible:ring-gray-400
            focus-visible:ring-offset-2

            disabled:cursor-wait disabled:opacity-50

            aria-pressed:border-gray-900
            aria-pressed:bg-gray-900
            aria-pressed:text-white">
        <span class="text-xs">▲</span>

        <span class="vote-count">
            {{ $count }}
        </span>
    </button>
@else
    <a href="{{ route('login', ['redirect' => request()->getRequestUri()]) }}" title="Log in to vote"
        class="inline-flex shrink-0 items-center gap-1.5
            rounded-full border border-gray-300 bg-gray-100
            px-3 py-1.5
            text-sm font-semibold text-gray-600
            shadow-sm transition duration-150

            hover:border-gray-400 hover:bg-gray-200
            hover:text-gray-950 hover:shadow
            active:scale-95">
        <span class="text-xs">▲</span>

        <span>
            {{ $count }}
        </span>
    </a>
@endauth
