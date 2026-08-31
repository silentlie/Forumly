<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold">
                Create Community
            </h1>
        </div>

        <form method="POST" action="{{ route('admin.communities.store') }}" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block font-medium">
                    Name
                </label>

                <input id="name" name="name" type="text" value="{{ old('name') }}"
                    class="mt-1 w-full rounded border px-3 py-2" required>

                @error('name')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="description" class="block font-medium">
                    Description
                </label>

                <textarea id="description" name="description" rows="5" class="mt-1 w-full rounded border px-3 py-2">{{ old('description') }}</textarea>

                @error('description')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <button type="submit" class="rounded bg-gray-900 px-4 py-2 text-white">
                Create Community
            </button>
        </form>
    </div>
</x-app-layout>
