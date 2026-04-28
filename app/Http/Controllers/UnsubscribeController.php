<?php

namespace App\Http\Controllers;

use App\Http\Resources\IdeaResource;
use App\Models\Idea;
use App\Models\User;
use Inertia\Response;

class UnsubscribeController extends Controller
{
    public function __invoke(Idea $idea, User $user): Response
    {
        $idea->subscribers()->detach($user->id);

        return inertia('Ideas/Unsubscribed', [
            'idea' => new IdeaResource($idea),
        ]);
    }
}
