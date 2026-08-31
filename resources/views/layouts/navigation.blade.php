<nav x-data="{ open: false }" class="border-b border-gray-100 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">

            {{-- Left side --}}
            <div class="flex items-center">
                {{-- Logo --}}
                <div class="flex shrink-0 items-center">
                    <a href="{{ route('posts.index') }}"
                        class="flex items-center gap-2 text-gray-900 transition hover:text-gray-600">
                        <x-application-logo class="block h-8 w-auto fill-current" />

                        <span class="text-lg font-bold tracking-tight">
                            Forumly
                        </span>
                    </a>
                </div>

                {{-- Navigation --}}
                <div class="hidden space-x-8 sm:ms-10 sm:flex">
                    <x-nav-link :href="route('communities.index')" :active="request()->routeIs('communities.*')">
                        {{ __('Communities') }}
                    </x-nav-link>
                </div>
            </div>

            {{-- Right side --}}
            <div class="hidden items-center gap-4 sm:flex">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex cursor-pointer items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition hover:text-gray-700 focus:outline-none">
                                <span>{{ Auth::user()->name }}</span>

                                <svg class="ms-1 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0
                                                                        111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0
                                                                        010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login', ['redirect' => request()->getRequestUri()]) }}"
                        class="text-sm font-medium text-gray-700 hover:text-gray-900">
                        Log in
                    </a>

                    <a href="{{ route('register') }}"
                        class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white
                            hover:bg-gray-700">
                        Register
                    </a>
                @endauth
            </div>

            {{-- Mobile hamburger --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="cursor-pointer inline-flex items-center justify-center rounded-md p-2 text-gray-400
                        transition hover:bg-gray-100 hover:text-gray-500">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />

                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="space-y-1 pb-3 pt-2">
            <x-responsive-nav-link :href="route('communities.index')" :active="request()->routeIs('communities.*')">
                {{ __('Communities') }}
            </x-responsive-nav-link>
        </div>

        <div class="border-t border-gray-200 pb-3 pt-4">
            @auth
                <div class="px-4">
                    <div class="text-base font-medium text-gray-800">
                        {{ Auth::user()->name }}
                    </div>

                    <div class="text-sm font-medium text-gray-500">
                        {{ Auth::user()->email }}
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="space-y-1">
                    <x-responsive-nav-link :href="route('login', ['redirect' => request()->getRequestUri()])">
                        {{ __('Log in') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>
