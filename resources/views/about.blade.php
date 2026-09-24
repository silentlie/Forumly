<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">
            About Forumly
        </h1>
    </x-slot>

    <div class="mx-auto max-w-4xl space-y-6">

        {{-- Introduction --}}
        <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-gray-900">
                What is Forumly?
            </h2>

            <p class="mt-3 leading-relaxed text-gray-600">
                Forumly is a community discussion platform where users can
                discover communities, create posts, join discussions, share
                attachments, and vote on content.
            </p>

            <p class="mt-3 leading-relaxed text-gray-600">
                The goal is to make it easy to find discussions around topics
                you care about and contribute to them.
            </p>
        </section>

        {{-- Features --}}
        <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-gray-900">
                What can you do?
            </h2>

            <div class="mt-5 grid gap-5 sm:grid-cols-2">
                <div>
                    <h3 class="font-semibold text-gray-900">
                        Explore communities
                    </h3>

                    <p class="mt-1 text-sm leading-relaxed text-gray-600">
                        Browse communities and discover posts organised around
                        different topics.
                    </p>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900">
                        Search discussions
                    </h3>

                    <p class="mt-1 text-sm leading-relaxed text-gray-600">
                        Search posts by title, content, or author to quickly
                        find relevant discussions.
                    </p>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900">
                        Create posts
                    </h3>

                    <p class="mt-1 text-sm leading-relaxed text-gray-600">
                        Logged-in users can create posts inside communities
                        and include optional file attachments.
                    </p>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900">
                        Join discussions
                    </h3>

                    <p class="mt-1 text-sm leading-relaxed text-gray-600">
                        Comment on posts and take part in conversations with
                        other Forumly users.
                    </p>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900">
                        Vote on posts
                    </h3>

                    <p class="mt-1 text-sm leading-relaxed text-gray-600">
                        Vote for posts you find useful or interesting. Click
                        the vote button again to remove your vote.
                    </p>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900">
                        Manage your posts
                    </h3>

                    <p class="mt-1 text-sm leading-relaxed text-gray-600">
                        You can edit or delete posts that you created.
                    </p>
                </div>
            </div>
        </section>

        {{-- How it works --}}
        <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-gray-900">
                How Forumly works
            </h2>

            <div class="mt-4 space-y-4 text-gray-600">
                <p>
                    <strong class="text-gray-900">Communities</strong>
                    group discussions by topic.
                </p>

                <p>
                    <strong class="text-gray-900">Posts</strong>
                    start a discussion and can include text and attachments.
                </p>

                <p>
                    <strong class="text-gray-900">Comments</strong>
                    let users respond to a post and continue the discussion.
                </p>

                <p>
                    <strong class="text-gray-900">Votes</strong>
                    let users highlight posts they find interesting or useful.
                </p>
            </div>
        </section>

        {{-- Call to action --}}
        <section class="rounded-xl border border-gray-200 bg-white p-6
                   text-center shadow-sm">
            <h2 class="text-xl font-semibold text-gray-900">
                Ready to explore?
            </h2>

            <p class="mt-2 text-gray-600">
                Browse the latest discussions or find a community that
                interests you.
            </p>

            <div class="mt-5 flex flex-wrap justify-center gap-3">
                <a href="{{ route('posts.index') }}"
                    class="rounded-lg bg-gray-900 px-5 py-2.5
                           text-sm font-semibold text-white
                           transition hover:bg-gray-700">
                    Browse posts
                </a>

                <a href="{{ route('communities.index') }}"
                    class="rounded-lg border border-gray-300 bg-white
                           px-5 py-2.5 text-sm font-semibold
                           text-gray-700 transition
                           hover:bg-gray-50">
                    View communities
                </a>
            </div>
        </section>

    </div>
</x-app-layout>
