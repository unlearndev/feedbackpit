<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReactionRequest;
use App\Models\Idea;
use Illuminate\Http\RedirectResponse;

class ReactionController extends Controller
{
    public function __invoke(StoreReactionRequest $request, Idea $idea): RedirectResponse
    {
        $user = $request->user();
        $emoji = $request->validated('emoji');

        $existing = $idea->reactions()
            ->where('user_id', $user->id)
            ->where('emoji', $emoji)
            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            $reaction = $idea->reactions()->make(['emoji' => $emoji]);
            $reaction->user()->associate($user);
            $reaction->save();
        }

        return redirect()->back();
    }
}
