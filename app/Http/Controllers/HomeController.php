<?php

namespace App\Http\Controllers;

use App\Http\Resources\IdeaResource;
use App\Models\Idea;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(): Response
    {
        $ideas = Idea::with('user', 'voters:id')->latest()->get();

        return inertia('Home', ['ideas' => IdeaResource::collection($ideas)]);
    }
}
