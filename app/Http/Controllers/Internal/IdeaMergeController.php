<?php

namespace App\Http\Controllers\Internal;

use App\Enums\IdeaStatus;
use App\Http\Controllers\Controller;
use App\Models\Idea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class IdeaMergeController extends Controller
{
    public function store(Request $request, Idea $idea): RedirectResponse
    {
        $target = Idea::find($request->input('target_id'));

        $idea->comments()->update(['idea_id' => $target->id]);
        $idea->reactions()->update(['idea_id' => $target->id]);

        foreach ($idea->voters as $voter) {
            $target->voters()->attach($voter->id);
        }

        $idea->merged_into_id = $target->id;
        $idea->status = IdeaStatus::Declined;
        $idea->save();

        return redirect()
            ->route('internal.ideas.show', $target)
            ->with('status', 'Idea merged into '.$target->title.'.');
    }
}
