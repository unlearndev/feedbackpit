<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIdeaRequest;
use App\Models\Idea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class IdeaController extends Controller
{
    public function show(Request $request, Idea $idea): Response
    {
        $idea->load('user:id,name');

        $user = $request->user();
        $idea->has_voted = $user ? $idea->voters()->where('user_id', $user->id)->exists() : false;

        return inertia('Ideas/Show', [
            'idea' => $idea,
        ]);
    }

    public function create(): Response
    {
        return inertia('Ideas/Create');
    }

    public function store(StoreIdeaRequest $request): RedirectResponse
    {
        $request->user()->ideas()->create($request->only(['title', 'description']));

        return redirect()->route('home')->with('message', 'Your idea has been submitted!');
    }
}
