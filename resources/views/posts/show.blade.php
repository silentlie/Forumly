<x-app-layout>
    <div class="mx-auto max-w-3xl py-8">
        {{-- Post --}}
        <x-post-card :post="$post" />

        {{-- Comments --}}
        <section class="mt-8">
            <h2 class="mb-4 text-xl font-bold text-gray-900">
                Comments
            </h2>

            @auth
                <form method="POST" action="{{ route('comments.store', $post) }}" class="mb-6">
                    @csrf

                    <textarea name="body" rows="4"
                        class="w-full rounded-xl border border-gray-300 bg-white p-4
                            shadow-sm transition
                            focus:border-gray-500 focus:ring-gray-500"
                        placeholder="Write a comment...">{{ old('body') }}</textarea>

                    @error('body')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                    <button type="submit"
                        class="mt-2 cursor-pointer rounded-lg bg-gray-900 px-4 py-2
                            text-sm font-semibold text-white shadow-sm transition
                            hover:bg-gray-700 active:bg-gray-950">
                        Comment
                    </button>
                </form>
            @else
                <p class="mb-6 text-gray-600">
                    <a href="{{ route('login', ['redirect' => request()->getRequestUri()]) }}"
                        class="font-medium text-gray-900 hover:underline">
                        Log in
                    </a>
                    to comment.
                </p>
            @endauth

            <div class="space-y-3">
                @forelse ($post->comments as $comment)
                    <article
                        class="rounded-xl border border-gray-200 bg-white p-4
                            shadow-sm">
                        <div class="text-sm text-gray-500">
                            {{ $comment->user->name }}

                            <span class="mx-1">&middot;</span>

                            {{ $comment->created_at->diffForHumans() }}
                        </div>

                        <p class="mt-2 leading-relaxed text-gray-700">
                            {{ $comment->body }}
                        </p>
                    </article>
                @empty
                    <p class="text-gray-500">
                        No comments yet.
                    </p>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
