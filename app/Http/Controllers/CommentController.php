<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Idea;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Idea $idea): RedirectResponse
    {
        $idea->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $request->input('body'),
            'is_internal' => false,
        ]);

        return back()->with('status', 'Comment posted!');
    }
}
