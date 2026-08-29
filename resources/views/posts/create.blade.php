<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Create Post</h1>

        <form method="POST" action="{{ route('posts.store') }}">
            @csrf

            <div class="mb-4">
                <label for="community_id">Community</label>

                <select id="community_id" name="community_id" class="block w-full">
                    @foreach ($communities as $community)
                        <option value="{{ $community->id }}" @selected(old('community_id') == $community->id)>
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

                <input id="title" name="title" type="text" value="{{ old('title') }}" class="block w-full">

                @error('title')
                    <p>{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="body">Body</label>

                <textarea id="body" name="body" class="block w-full" rows="8">{{ old('body') }}</textarea>

                @error('body')
                    <p>{{ $message }}</p>
                @enderror
            </div>

            <button type="submit">
                Create Post
            </button>
        </form>
    </div>
</x-app-layout>
