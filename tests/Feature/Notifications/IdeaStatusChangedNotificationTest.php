<?php

use App\Enums\IdeaStatus;
use App\Models\Idea;
use App\Models\IdeaStatusUpdate;
use App\Models\User;
use App\Notifications\IdeaStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('builds the mail message from the status update payload', function () {
    $author = User::factory()->create();
    $idea = Idea::factory()->for($author)->create(['status' => IdeaStatus::Planned]);
    $statusUpdate = IdeaStatusUpdate::factory()
        ->for($idea)
        ->for(User::factory()->teamMember())
        ->create([
            'from_status' => IdeaStatus::UnderReview,
            'to_status' => IdeaStatus::Planned,
            'message' => 'Roadmapped for Q2',
        ]);

    $mail = (new IdeaStatusChanged($statusUpdate))->toMail($author);

    expect($mail->subject)->toContain($idea->title)
        ->and($mail->viewData['message'])->toBe('Roadmapped for Q2')
        ->and($mail->viewData['oldStatus'])->toBe(IdeaStatus::UnderReview)
        ->and($mail->viewData['newStatus'])->toBe(IdeaStatus::Planned)
        ->and($mail->viewData['idea']->is($idea))->toBeTrue();
});

it('queues the notification', function () {
    expect(is_subclass_of(IdeaStatusChanged::class, ShouldQueue::class))->toBeTrue();
});
