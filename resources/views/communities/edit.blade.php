<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">
        <div class="mb-4">
            <h1 class="mt-4 text-2xl font-bold text-gray-900">
                Edit Community
            </h1>
        </div>
        <form method="POST" action="{{ route('admin.communities.update', $community) }}" class="space-y-6">
            @csrf
            @method('PATCH')

            <div>
                <label for="name" class="block font-medium">
                    Name
                </label>

                <input id="name" name="name" type="text" value="{{ old('name', $community->name) }}"
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

                <textarea id="description" name="description" rows="5" class="mt-1 w-full rounded border px-3 py-2">{{ old('description', $community->description) }}</textarea>

                @error('description')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex items-center justify-between">

                <button type="submit" class="rounded bg-gray-900 px-4 py-2 text-white">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
