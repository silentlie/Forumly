<div x-data="{
    open: false,
    step: 1,

    init() {
        this.open =
            localStorage.getItem('forumly-intro-seen') !== 'true';
    },

    next() {
        if (this.step < 3) {
            this.step++;
        } else {
            this.close();
        }
    },

    previous() {
        if (this.step > 1) {
            this.step--;
        }
    },

    close() {
        localStorage.setItem('forumly-intro-seen', 'true');
        this.open = false;
    },

    reopen() {
        this.step = 1;
        this.open = true;
    }
}" @open-forumly-guide.window="reopen()" @keydown.escape.window="if (open) close()" x-show="open"
    x-cloak class="fixed inset-0 z-50" aria-labelledby="forumly-guide-title" role="dialog" aria-modal="true">
    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-gray-900/50" @click="close()"></div>

    {{-- Modal --}}
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="relative w-full max-w-lg rounded-2xl bg-white
                   shadow-xl" @click.stop>
            {{-- Close button --}}
            <button type="button" @click="close()" aria-label="Close introduction"
                class="absolute right-4 top-4 inline-flex h-9 w-9
                       cursor-pointer items-center justify-center
                       rounded-full text-gray-400 transition
                       hover:bg-gray-100 hover:text-gray-700">
                <x-heroicon-o-x-mark class="h-5 w-5" />
            </button>

            <div class="p-6 sm:p-8">
                {{-- Step 1 --}}
                <div x-show="step === 1">
                    <p class="mb-2 text-sm font-medium text-gray-500">
                        Welcome
                    </p>

                    <h2 id="forumly-guide-title" class="text-2xl font-bold text-gray-900">
                        Welcome to Forumly
                    </h2>

                    <p class="mt-4 leading-relaxed text-gray-600">
                        Forumly is a community discussion platform where
                        you can discover communities, share posts, join
                        discussions, and vote on content.
                    </p>

                    <p class="mt-3 leading-relaxed text-gray-600">
                        Browse freely, or create an account to start
                        contributing to the conversation.
                    </p>
                </div>

                {{-- Step 2 --}}
                <div x-show="step === 2">
                    <p class="mb-2 text-sm font-medium text-gray-500">
                        Explore and contribute
                    </p>

                    <h2 class="text-2xl font-bold text-gray-900">
                        Find discussions that interest you
                    </h2>

                    <div class="mt-5 space-y-4">
                        <div>
                            <p class="font-semibold text-gray-900">
                                Browse and search
                            </p>
                            <p class="mt-1 text-sm leading-relaxed text-gray-600">
                                Explore posts and communities, or search
                                for topics, content, and authors.
                            </p>
                        </div>

                        <div>
                            <p class="font-semibold text-gray-900">
                                Create posts
                            </p>
                            <p class="mt-1 text-sm leading-relaxed text-gray-600">
                                Share your own discussion with a title,
                                message, community, and optional
                                attachments.
                            </p>
                        </div>

                        <div>
                            <p class="font-semibold text-gray-900">
                                Join the discussion
                            </p>
                            <p class="mt-1 text-sm leading-relaxed text-gray-600">
                                Open a post to read comments and add your
                                own response.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div x-show="step === 3">
                    <p class="mb-2 text-sm font-medium text-gray-500">
                        How Forumly works
                    </p>

                    <h2 class="text-2xl font-bold text-gray-900">
                        A few things to know
                    </h2>

                    <div class="mt-5 space-y-4">
                        <div>
                            <p class="font-semibold text-gray-900">
                                Communities
                            </p>
                            <p class="mt-1 text-sm leading-relaxed text-gray-600">
                                Communities organise posts around
                                different topics.
                            </p>
                        </div>

                        <div>
                            <p class="font-semibold text-gray-900">
                                Votes
                            </p>
                            <p class="mt-1 text-sm leading-relaxed text-gray-600">
                                Vote for posts you find useful or
                                interesting. Clicking again removes your
                                vote.
                            </p>
                        </div>

                        <div>
                            <p class="font-semibold text-gray-900">
                                Attachments
                            </p>
                            <p class="mt-1 text-sm leading-relaxed text-gray-600">
                                Posts can include files that other users
                                can download.
                            </p>
                        </div>

                        <div>
                            <p class="font-semibold text-gray-900">
                                Your posts
                            </p>
                            <p class="mt-1 text-sm leading-relaxed text-gray-600">
                                You can edit or delete posts that you
                                created.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Progress --}}
                <div class="mt-8 flex items-center justify-center gap-2">
                    <template x-for="number in 3" :key="number">
                        <button type="button" @click="step = number"
                            class="h-2.5 w-2.5 cursor-pointer rounded-full
                                   transition"
                            :class="step === number ?
                                'bg-gray-900' :
                                'bg-gray-300 hover:bg-gray-400'"
                            :aria-label="`Go to introduction step ${number}`"></button>
                    </template>
                </div>

                {{-- Navigation --}}
                <div class="mt-6 flex items-center"
                    :class="step > 1 ?
                        'justify-between' :
                        'justify-end'">
                    <button x-show="step > 1" type="button" @click="previous()"
                        class="cursor-pointer rounded-lg px-4 py-2
                               text-sm font-medium text-gray-600
                               transition hover:bg-gray-100
                               hover:text-gray-900">
                        Back
                    </button>

                    <button type="button" @click="next()"
                        class="cursor-pointer rounded-lg bg-gray-900
                               px-5 py-2.5 text-sm font-semibold
                               text-white transition hover:bg-gray-700">
                        <span x-show="step < 3">
                            Next
                        </span>

                        <span x-show="step === 3">
                            Start exploring
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
