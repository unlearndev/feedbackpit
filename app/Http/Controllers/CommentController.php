<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Idea;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Idea $idea): RedirectResponse
    {
        $comment = new Comment([
            'body' => $request->input('body'),
            'is_internal' => false,
        ]);

        $comment->user()->associate($request->user());
        $comment->idea()->associate($idea);
        $comment->save();

        return back()->with('status', 'Comment posted!');
    }
}
