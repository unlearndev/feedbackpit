<?php

namespace App\Http\Controllers;

use App\Http\Resources\IdeaResource;
use App\Models\Idea;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        $ideas = Idea::with('user', 'voters:id', 'subscribers:id')
            ->withCount(['publicComments as comments_count'])
            ->orderByDesc('votes')
            ->paginate(12);

        return inertia('Dashboard', ['ideas' => IdeaResource::collection($ideas)]);
    }
}
