<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $communities = Community::withCount('posts')
            ->orderBy('name')
            ->get();

        return view('communities.index', compact('communities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('communities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:communities,name',
            ],
            'description' => [
                'nullable',
                'string',
            ],
        ]);

        Community::create($validated);

        return redirect()
            ->route('communities.index')
            ->with('success', 'Community created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Community $community)
    {
        $query = $community->posts()
            ->with(['user', 'community'])
            ->withCount('voters');

        if (Auth::check()) {
            $query->withExists([
                'voters as has_voted' => function ($query) {
                    $query->whereKey(Auth::id());
                },
            ]);
        }

        $posts = $query
            ->latest()
            ->paginate(10);

        return view('communities.show', compact('community', 'posts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Community $community)
    {
        return view('communities.edit', compact('community'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Community $community)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('communities', 'name')->ignore($community),
            ],
            'description' => [
                'nullable',
                'string',
            ],
        ]);

        $community->update($validated);

        return redirect()
            ->route('communities.index')
            ->with('success', 'Community updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Community $community)
    {
        if ($community->posts()->exists()) {
            return redirect()
                ->route('communities.index')
                ->with(
                    'error',
                    'Cannot delete a community that contains posts.'
                );
        }

        $community->delete();

        return redirect()
            ->route('communities.index')
            ->with('success', 'Community deleted successfully.');
    }
}
