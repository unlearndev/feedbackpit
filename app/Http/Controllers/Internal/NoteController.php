<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInternalNoteRequest;
use App\Models\Comment;
use App\Models\Idea;
use Illuminate\Http\RedirectResponse;

class NoteController extends Controller
{
    public function store(StoreInternalNoteRequest $request, Idea $idea): RedirectResponse
    {
        $comment = new Comment([
            'body' => $request->input('body'),
            'is_internal' => true,
        ]);

        $comment->user()->associate($request->user());
        $comment->idea()->associate($idea);
        $comment->save();

        return back()->with('status', 'Note added!');
    }
}
