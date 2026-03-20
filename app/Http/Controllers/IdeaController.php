<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIdeaRequest;
use App\Http\Resources\IdeaResource;
use App\Models\Idea;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class IdeaController extends Controller
{
    public function show(Idea $idea): Response
    {
        $idea->load('user', 'voters:id');

        return inertia('Ideas/Show', [
            'idea' => new IdeaResource($idea),
        ]);
    }

    public function create(): Response
    {
        return inertia('Ideas/Create');
    }

    public function store(StoreIdeaRequest $request): RedirectResponse
    {
        $request->user()->ideas()->create($request->only(['title', 'description']));

        return redirect()->route('dashboard')->with('status', 'Your feedback has been submitted!');
    }
}
