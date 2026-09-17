<?php

namespace App\Modules\Feedback\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use App\Modules\Feedback\Http\Requests\StoreReactionRequest;
use Illuminate\Http\RedirectResponse;

class ReactionController extends Controller
{
    public function __invoke(StoreReactionRequest $request, Idea $idea): RedirectResponse
    {
        $user = $request->user();
        $emoji = $request->validated('emoji');

        $existingReaction = $idea->reactions()
            ->where('user_id', $user->id)
            ->where('emoji', $emoji)
            ->first();

        if ($existingReaction) {
            $existingReaction->delete();
        } else {
            $reaction = $idea->reactions()->make(['emoji' => $emoji]);
            $reaction->user()->associate($user);
            $reaction->save();
        }

        return redirect()->back();
    }
}
