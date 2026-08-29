<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Community;


class CommunityController extends Controller
{
    public function show(Community $community)
    {
        $posts = $community->posts()
            ->with(['user', 'community'])
            ->latest()
            ->paginate(10);

        return view('communities.show', compact('community', 'posts'));
    }
}
