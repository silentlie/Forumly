<x-app-layout>
    <div class="mx-auto max-w-3xl py-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">
                Edit Post
            </h1>

            <p class="mt-1 text-gray-600">
                Update your post details and attachments.
            </p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PATCH')

                {{-- Community --}}
                <div>
                    <label for="community_id" class="block text-sm font-medium text-gray-700">
                        Community
                    </label>

                    <select id="community_id" name="community_id"
                        class="mt-1 block w-full rounded-lg
                            border border-gray-300 bg-white
                            focus:border-gray-500
                            focus:ring-1 focus:ring-gray-500">
                        @foreach ($communities as $community)
                            <option value="{{ $community->id }}" @selected(old('community_id', $post->community_id) == $community->id)>
                                {{ $community->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('community_id')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Title --}}
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">
                        Title
                    </label>

                    <input id="title" name="title" type="text" value="{{ old('title', $post->title) }}"
                        class="mt-1 block w-full rounded-lg
                            border border-gray-300 bg-white
                            focus:border-gray-500
                            focus:ring-1 focus:ring-gray-500">

                    @error('title')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Body --}}
                <div>
                    <label for="body" class="block text-sm font-medium text-gray-700">
                        Body
                    </label>

                    <textarea id="body" name="body" rows="8"
                        class="mt-1 block w-full rounded-lg
                            border border-gray-300 bg-white
                            focus:border-gray-500
                            focus:ring-1 focus:ring-gray-500">{{ old('body', $post->body) }}</textarea>

                    @error('body')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Current attachments --}}
                @if (!empty($post->file_paths))
                    <div>
                        <p class="block text-sm font-medium text-gray-700">
                            Current attachments
                        </p>

                        <div
                            class="mt-2 divide-y divide-gray-100
                                rounded-lg border border-gray-200">
                            @foreach ($post->file_paths as $index => $file)
                                <label
                                    class="flex cursor-pointer
                                        items-center gap-3 px-4 py-3">
                                    <input type="checkbox" name="remove_files[]" value="{{ $index }}"
                                        class="rounded border-gray-300">

                                    <span
                                        class="min-w-0 flex-1 truncate
                                            text-sm text-gray-700">
                                        {{ $file['name'] }}
                                    </span>

                                    <span class="text-sm font-medium text-red-600">
                                        Remove
                                    </span>
                                </label>
                            @endforeach
                        </div>

                        @error('remove_files')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                        @error('remove_files.*')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                @endif

                {{-- New attachments --}}
                <div x-data="filePicker">
                    <label class="block text-sm font-medium text-gray-700">
                        Add attachments
                    </label>

                    <div class="mt-2 flex flex-wrap items-center gap-2">
                        <label for="files"
                            class="inline-flex cursor-pointer items-center
                rounded-lg border border-gray-300
                bg-white px-3 py-2
                text-sm font-medium text-gray-700
                transition hover:bg-gray-50">
                            <x-heroicon-o-plus class="h-4 w-4" /> Choose files
                        </label>

                        <input x-ref="fileInput" id="files" name="files[]" type="file" multiple class="hidden"
                            @change="addFiles($event)">

                        <template x-for="(item, index) in files"
                            :key="`${item.name}-${item.size}-${item.lastModified}`">
                            <span
                                class="inline-flex max-w-full items-center gap-2
                    rounded-full border border-gray-200
                    bg-gray-100 px-3 py-1.5
                    text-sm text-gray-700">
                                <span class="max-w-52 truncate" x-text="item.name"></span>

                                <button type="button" aria-label="Remove attachment"
                                    class="cursor-pointer text-gray-400
        transition hover:text-red-600"
                                    @click="removeFile(index)">
                                    <x-heroicon-o-x-mark class="h-4 w-4" />
                                </button>
                            </span>
                        </template>
                    </div>

                    <p class="mt-2 text-sm text-gray-500">
                        Up to 5 files, maximum 10 MB each.
                    </p>

                    @error('files')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                    @error('files.*')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3
                        border-t border-gray-100 pt-6">
                    <a href="{{ route('posts.show', $post) }}"
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
    </div>
</x-app-layout>
