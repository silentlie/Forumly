@if (session('success') || session('error'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
        class="fixed right-4 top-20 z-50 w-full max-w-sm">
        <div @class([
            'flex items-start gap-3 rounded-xl border px-4 py-3 shadow-lg',
            'border-green-200 bg-green-50 text-green-800' => session('success'),
            'border-red-200 bg-red-50 text-red-800' => session('error'),
        ])>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-medium">
                    {{ session('success') ?? session('error') }}
                </p>
            </div>

            <button type="button" @click="show = false"
                class="shrink-0 cursor-pointer opacity-60 transition hover:opacity-100" aria-label="Dismiss notification">
                <x-heroicon-o-x-mark class="h-5 w-5" />
            </button>
        </div>
    </div>
@endif
