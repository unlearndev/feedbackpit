<?php

namespace App\Modules\Internal\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Idea;
use App\Modules\Internal\Http\Requests\StoreInternalNoteRequest;
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
