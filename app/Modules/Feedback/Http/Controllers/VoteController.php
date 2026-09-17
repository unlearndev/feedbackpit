<?php

namespace App\Modules\Feedback\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use App\Modules\Feedback\Actions\ToggleVote;
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
