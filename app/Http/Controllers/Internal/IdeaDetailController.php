<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\IdeaResource;
use App\Models\Idea;
use Inertia\Response;

class IdeaDetailController extends Controller
{
    public function show(Idea $idea): Response
    {
        $idea->load('user', 'voters:id');

        $comments = $idea->comments()
            ->where('is_internal', false)
            ->with('user')
            ->oldest()
            ->get();

        $internalComments = $idea->comments()
            ->where('is_internal', true)
            ->with('user')
            ->oldest()
            ->get();

        return inertia('Internal/Ideas/Show', [
            'idea' => new IdeaResource($idea),
            'comments' => CommentResource::collection($comments),
            'internalComments' => CommentResource::collection($internalComments),
        ]);
    }
}
