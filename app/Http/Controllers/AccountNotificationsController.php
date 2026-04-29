<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubscribedIdeaResource;
use App\Models\Idea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class AccountNotificationsController extends Controller
{
    public function edit(Request $request): Response
    {
        return inertia('Account/Notifications', [
            'ideas' => SubscribedIdeaResource::collection(
                $request->user()
                    ->subscribedIdeas()
                    ->with('latestStatusUpdate')
                    ->orderByPivot('created_at', 'desc')
                    ->get()
            ),
        ]);
    }

    public function store(Request $request, Idea $idea): RedirectResponse
    {
        $request->user()->subscribedIdeas()->syncWithoutDetaching([$idea->id]);

        return back()->with('status', 'Subscribed to "'.$idea->title.'".');
    }

    public function destroy(Request $request, Idea $idea): RedirectResponse
    {
        $request->user()->subscribedIdeas()->detach($idea->id);

        return back()->with('status', 'Unsubscribed from "'.$idea->title.'".');
    }
}
