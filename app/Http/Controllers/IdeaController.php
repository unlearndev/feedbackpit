<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIdeaRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class IdeaController extends Controller
{
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
