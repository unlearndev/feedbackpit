<?php

namespace App\Http\Controllers;

use App\Actions\Votes\ToggleVote;
use App\Models\Idea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function __invoke(Request $request, Idea $idea, ToggleVote $toggleVote): RedirectResponse
    {
        $toggleVote($request->user(), $idea);

        return redirect()->back();
    }
}
