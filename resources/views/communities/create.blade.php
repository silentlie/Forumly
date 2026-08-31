<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">
            Create Community
        </h1>

        <p class="mt-1 text-gray-600">
            Create a new space for discussions and posts.
        </p>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('admin.communities.store') }}" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">
                    Name
                </label>

                <input id="name" name="name" type="text" value="{{ old('name') }}" required
                    class="mt-1 block w-full rounded-lg
                            border border-gray-300 bg-white
                            focus:border-gray-500
                            focus:ring-1 focus:ring-gray-500">

                @error('name')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">
                    Description
                </label>

                <textarea id="description" name="description" rows="5"
                    class="mt-1 block w-full rounded-lg
                            border border-gray-300 bg-white
                            focus:border-gray-500
                            focus:ring-1 focus:ring-gray-500">{{ old('description') }}</textarea>

                @error('description')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3
                        border-t border-gray-100 pt-6">
                <a href="{{ route('communities.index') }}"
                    class="rounded-lg border border-gray-300
                            bg-white px-4 py-2
                            text-sm font-semibold text-gray-700
                            transition hover:bg-gray-50">
                    Cancel
                </a>

                <button type="submit"
                    class="inline-flex cursor-pointer items-center gap-1.5
                            rounded-lg bg-gray-900 px-4 py-2
                            text-sm font-semibold text-white
                            transition
                            hover:bg-gray-700
                            active:bg-gray-950">
                    <x-heroicon-o-plus class="h-4 w-4" />

                    Create Community
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
