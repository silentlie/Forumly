<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::with(['user', 'community'])
            ->withCount('voters');

        if (Auth::check()) {
            $query->withExists([
                'voters as has_voted' => function ($query) {
                    $query->whereKey(Auth::id());
                },
            ]);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('community', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $posts = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $communities = Community::orderBy('name')->get();

        return view('posts.create', compact('communities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'community_id' => ['required', 'exists:communities,id'],
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'files' => ['nullable', 'array'],
            'files.*' => ['file', 'max:10240'],
        ]);

        $filePaths = [];

        $files = $request->file('files');

        if (is_array($files)) {
            foreach ($files as $file) {
                $path = $file->store('posts');

                $filePaths[] = [
                    'path' => $path,
                    'name' => $file->getClientOriginalName(),
                    'mime' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ];
            }
        }

        $community = Community::findOrFail($validated['community_id']);

        $post = new Post([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'file_paths' => $filePaths,
        ]);

        $post->user()->associate($request->user());
        $post->community()->associate($community);

        $post->save();

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load([
            'user',
            'community',
            'comments.user',
        ]);

        $post->loadCount('voters');

        if (Auth::check()) {
            $post->loadExists([
                'voters as has_voted' => function ($query) {
                    $query->whereKey(Auth::id());
                },
            ]);
        }

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);
        $communities = Community::orderBy('name')->get();

        return view('posts.edit', compact('post', 'communities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('update', $post);
        $validated = $request->validate([
            'community_id' => ['required', 'exists:communities,id'],
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'files' => ['nullable', 'array'],
            'files.*' => ['file', 'max:10240'],
            'remove_files' => ['nullable', 'array'],
            'remove_files.*' => ['integer'],
        ]);

        $filePaths = $post->file_paths ?? [];

        // Remove selected existing files.
        foreach ($validated['remove_files'] ?? [] as $index) {
            if (! isset($filePaths[$index])) {
                continue;
            }

            Storage::delete($filePaths[$index]['path']);

            unset($filePaths[$index]);
        }

        // Re-index the array after unset().
        $filePaths = array_values($filePaths);

        // Add newly uploaded files.
        $files = $request->file('files');
        if (is_array($files)) {
            foreach ($files as $file) {
                $path = $file->store('posts');

                $filePaths[] = [
                    'path' => $path,
                    'name' => $file->getClientOriginalName(),
                    'mime' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ];
            }
        }


        $post->update([
            'community_id' => $validated['community_id'],
            'title' => $validated['title'],
            'body' => $validated['body'],
            'file_paths' => $filePaths,
        ]);

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        foreach ($post->file_paths ?? [] as $file) {
            Storage::delete($file['path']);
        }

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post deleted successfully.');
    }

    public function downloadFile(Post $post, int $index)
    {
        $file = $post->file_paths[$index] ?? null;

        abort_unless($file, 404);

        return Storage::download(
            $file['path'],
            $file['name']
        );
    }

    public function createForCommunity(Community $community)
    {
        return view('posts.create', compact('community'));
    }
}
