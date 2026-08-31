<x-app-layout>
    <div class="mx-auto max-w-3xl py-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">
                Create Post
            </h1>

            <p class="mt-1 text-gray-600">
                Share something with the community.
            </p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Community --}}
                <div>
                    <label for="community_id" class="block text-sm font-medium text-gray-700">
                        Community
                    </label>

                    @isset($community)
                        <div
                            class="mt-1 rounded-lg border border-gray-200
                                bg-gray-100 px-3 py-2 text-gray-700">
                            {{ $community->name }}
                        </div>

                        <input type="hidden" name="community_id" value="{{ $community->id }}">
                    @else
                        <select id="community_id" name="community_id"
                            class="mt-1 block w-full rounded-lg
                                border border-gray-300 bg-white
                                focus:border-gray-500
                                focus:ring-1 focus:ring-gray-500">
                            @foreach ($communities as $optionCommunity)
                                <option value="{{ $optionCommunity->id }}" @selected(old('community_id') == $optionCommunity->id)>
                                    {{ $optionCommunity->name }}
                                </option>
                            @endforeach
                        </select>
                    @endisset

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

                    <input id="title" name="title" type="text" value="{{ old('title') }}"
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
                            focus:ring-1 focus:ring-gray-500">{{ old('body') }}</textarea>

                    @error('body')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Attachments --}}
                <div x-data="filePicker">
                    <label class="block text-sm font-medium text-gray-700">
                        Attachments
                    </label>

                    <div class="mt-2 flex flex-wrap items-center gap-2">
                        <label for="files"
                            class="inline-flex cursor-pointer items-center
                                rounded-lg border border-gray-300
                                bg-white px-3 py-2
                                text-sm font-medium text-gray-700
                                transition hover:bg-gray-50">
                            + Choose files
                        </label>

                        <input x-ref="fileInput" id="files" name="files[]" type="file" multiple class="hidden"
                            @change="addFiles($event)">

                        <template x-for="(item, index) in files"
                            :key="`${item.name}-${item.size}-${item.lastModified}`">
                            <span
                                class="inline-flex max-w-full items-center
                                    gap-2 rounded-full
                                    border border-gray-200
                                    bg-gray-100 px-3 py-1.5
                                    text-sm text-gray-700">
                                <span class="max-w-52 truncate" x-text="item.name"></span>

                                <button type="button" aria-label="Remove attachment"
                                    class="cursor-pointer text-gray-400
                                        transition hover:text-red-600"
                                    @click="removeFile(index)">
                                    ×
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
                    @isset($community)
                        <a href="{{ route('communities.show', $community) }}"
                            class="rounded-lg border border-gray-300
                                bg-white px-4 py-2
                                text-sm font-semibold text-gray-700
                                transition hover:bg-gray-50">
                            Cancel
                        </a>
                    @else
                        <a href="{{ route('posts.index') }}"
                            class="rounded-lg border border-gray-300
                                bg-white px-4 py-2
                                text-sm font-semibold text-gray-700
                                transition hover:bg-gray-50">
                            Cancel
                        </a>
                    @endisset

                    <button type="submit"
                        class="cursor-pointer rounded-lg
                            bg-gray-900 px-4 py-2
                            text-sm font-semibold text-white
                            transition
                            hover:bg-gray-700
                            active:bg-gray-950">
                        Create Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
