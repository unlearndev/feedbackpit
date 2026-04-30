<?php

namespace App\Http\Controllers;

use App\Actions\Comments\PostComment;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Idea;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Idea $idea, PostComment $postComment): RedirectResponse
    {
        $postComment($request->user(), $idea, (string) $request->input('body'));

        return back()->with('status', 'Comment posted!');
    }
}
