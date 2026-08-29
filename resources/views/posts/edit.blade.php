<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Edit Post</h1>

        <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="community_id">Community</label>

                <select id="community_id" name="community_id" class="block w-full">
                    @foreach ($communities as $community)
                        <option value="{{ $community->id }}" @selected(old('community_id', $post->community_id) == $community->id)>
                            {{ $community->name }}
                        </option>
                    @endforeach
                </select>

                @error('community_id')
                    <p>{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="title">Title</label>

                <input id="title" name="title" type="text" value="{{ old('title', $post->title) }}"
                    class="block w-full">

                @error('title')
                    <p>{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="body">Body</label>

                <textarea id="body" name="body" class="block w-full" rows="8">{{ old('body', $post->body) }}</textarea>

                @error('body')
                    <p>{{ $message }}</p>
                @enderror
            </div>

            @if (!empty($post->file_paths))
                <div class="mb-4">
                    <p class="font-semibold mb-2">Current attachments</p>

                    @foreach ($post->file_paths as $index => $file)
                        <label class="block mb-2">
                            <input type="checkbox" name="remove_files[]" value="{{ $index }}">

                            Remove {{ $file['name'] }}
                        </label>
                    @endforeach

                    @error('remove_files')
                        <p>{{ $message }}</p>
                    @enderror

                    @error('remove_files.*')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
            @endif

            <div class="mb-4">
                <label for="files">Add attachments</label>

                <input id="files" name="files[]" type="file" multiple class="block w-full">

                @error('files')
                    <p>{{ $message }}</p>
                @enderror

                @error('files.*')
                    <p>{{ $message }}</p>
                @enderror
            </div>

            <button type="submit">
                Update Post
            </button>
        </form>
    </div>
</x-app-layout>
