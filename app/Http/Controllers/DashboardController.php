<?php

namespace App\Http\Controllers;

use App\Http\Resources\IdeaResource;
use App\Models\Idea;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        $ideas = Idea::with('user', 'voters:id')->latest()->get();

        return inertia('Dashboard', ['ideas' => IdeaResource::collection($ideas)]);
    }
}
