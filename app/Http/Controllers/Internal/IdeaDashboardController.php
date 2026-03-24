<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Http\Resources\IdeaResource;
use App\Models\Idea;
use Inertia\Response;

class IdeaDashboardController extends Controller
{
    public function __invoke(): Response
    {
        $ideas = Idea::with('user', 'voters:id')
            ->withCount(['comments' => fn ($query) => $query->where('is_internal', false)])
            ->latest()
            ->get();

        return inertia('Internal/Ideas/Index', [
            'ideas' => IdeaResource::collection($ideas),
        ]);
    }
}
