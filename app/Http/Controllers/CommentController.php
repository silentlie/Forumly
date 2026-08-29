<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $comment = new Comment([
            'body' => $validated['body'],
        ]);

        $comment->user()->associate($request->user());
        $comment->post()->associate($post);

        $comment->save();

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Comment added successfully.');
    }
}
