<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function toggle(Request $request, Post $post)
    {
        $result = $request->user()
            ->votedPosts()
            ->toggle($post->id);

        return response()->json([
            'voted' => count($result['attached']) > 0,
            'count' => $post->voters()->count(),
        ]);
    }
}
