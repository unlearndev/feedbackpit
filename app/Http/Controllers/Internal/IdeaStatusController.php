<?php

namespace App\Http\Controllers\Internal;

use App\Enums\IdeaStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateIdeaStatusRequest;
use App\Models\Idea;
use App\Models\IdeaStatusUpdate;
use App\Notifications\IdeaStatusChanged;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class IdeaStatusController extends Controller
{
    public function update(UpdateIdeaStatusRequest $request, Idea $idea): RedirectResponse
    {
        $newStatus = IdeaStatus::from((string) $request->input('status'));
        $oldStatus = $idea->status;

        if ($newStatus === $oldStatus) {
            return back()->with('status', 'Status was already set to '.$newStatus->label().'.');
        }

        $statusUpdate = DB::transaction(function () use ($idea, $request, $oldStatus, $newStatus) {
            $statusUpdate = new IdeaStatusUpdate([
                'from_status' => $oldStatus,
                'to_status' => $newStatus,
                'message' => $request->input('message') ?: null,
            ]);
            $statusUpdate->idea()->associate($idea);
            $statusUpdate->user()->associate($request->user());
            $statusUpdate->save();

            $idea->status = $newStatus;
            $idea->save();

            return $statusUpdate;
        });

        $statusUpdate->setRelation('idea', $idea);

        $recipients = $idea->subscribers()
            ->where('users.id', '!=', $request->user()->id)
            ->get();

        if ($recipients->isNotEmpty()) {
            Notification::send($recipients, new IdeaStatusChanged($statusUpdate));
        }

        return back()->with('status', 'Status updated to '.$newStatus->label().'.');
    }
}
