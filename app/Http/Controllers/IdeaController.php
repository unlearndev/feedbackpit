<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\IdeaResource;
use App\Models\Idea;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class IdeaController extends Controller
{
    public function show(Idea $idea): Response
    {
        $idea->load(['user', 'voters:id', 'subscribers:id', 'latestStatusUpdate.user', 'reactions']);

        return inertia('Ideas/Show', [
            'idea' => new IdeaResource($idea),
            'comments' => CommentResource::collection(
                $idea->comments()->where('is_internal', false)->with('user')->oldest()->get()
            ),
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

    public function edit(Idea $idea): Response
    {
        $this->authorize('update', $idea);

        return inertia('Ideas/Edit', [
            'idea' => new IdeaResource($idea),
        ]);
    }

    public function update(UpdateIdeaRequest $request, Idea $idea): RedirectResponse
    {
        $idea->update($request->only(['title', 'description']));

        return redirect()->route('feedback.show', $idea)->with('status', 'Your feedback has been updated!');
    }

    public function destroy(Idea $idea): RedirectResponse
    {
        $this->authorize('delete', $idea);

        $idea->delete();

        return redirect()->route('dashboard')->with('status', 'Your feedback has been deleted!');
    }
}
