<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">
            Edit Community
        </h1>

        <p class="mt-1 text-gray-600">
            Update the community name and description.
        </p>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('admin.communities.update', $community) }}" class="space-y-6">
            @csrf
            @method('PATCH')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">
                    Name
                </label>

                <input id="name" name="name" type="text" value="{{ old('name', $community->name) }}" required
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
                            focus:ring-1 focus:ring-gray-500">{{ old('description', $community->description) }}</textarea>

                @error('description')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3
                        border-t border-gray-100 pt-6">
                <a href="{{ route('communities.show', $community) }}"
                    class="rounded-lg border border-gray-300
                            bg-white px-4 py-2
                            text-sm font-semibold text-gray-700
                            transition hover:bg-gray-50">
                    Cancel
                </a>

                <button type="submit"
                    class="cursor-pointer rounded-lg
                            bg-gray-900 px-4 py-2
                            text-sm font-semibold text-white
                            transition
                            hover:bg-gray-700
                            active:bg-gray-950">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
