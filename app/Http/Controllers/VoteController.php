<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    public function __invoke(Idea $idea): RedirectResponse
    {
        $user = request()->user();

        DB::transaction(function () use ($idea, $user) {
            $idea->voters()->toggle($user->id);
            $idea->votes = $idea->voters()->count();
            $idea->save();
        });

        return redirect()->back();
    }
}
