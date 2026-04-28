<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIdeaRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\IdeaResource;
use App\Models\Idea;
use App\Services\IdeaSimilarityService;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class IdeaController extends Controller
{
    public function show(Idea $idea): Response
    {
        $idea->load(['user', 'voters:id', 'latestStatusUpdate.user']);

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

    public function store(StoreIdeaRequest $request, IdeaSimilarityService $similarity): RedirectResponse
    {
        // run the similarity check against existing ideas
        $result = $similarity->findBestMatch(
            (string) $request->input('title'),
            $request->input('_match_key') ? (string) $request->input('_match_key') : null,
        );

        // 0.7 seems like a good threshold
        if ($result !== null && $result['score'] >= 0.7) {
            return redirect("/feedback/{$result['idea']->id}")
                ->with('status', 'We found a similar idea you might be looking for.');
        }

        $request->user()->ideas()->create($request->all());

        return redirect()->route('dashboard')->with('status', 'Your feedback has been submitted!');
    }
}
