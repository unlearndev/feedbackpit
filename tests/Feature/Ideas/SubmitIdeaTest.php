<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

$validPayload = fn () => [
    'title' => 'Dark mode support',
    'description' => 'It would be great to have a dark mode option for the app.',
];

// ---------------------------------------------------------------------------
// Auth guard
// ---------------------------------------------------------------------------

it('redirects guests to login', function () use ($validPayload) {
    $this->post(route('feedback.store'), $validPayload())
        ->assertRedirect(route('login'));
});

it('shows the form to authenticated users', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('feedback.create'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Ideas/Create'));
});

// ---------------------------------------------------------------------------
// Successful submission
// ---------------------------------------------------------------------------

it('creates an idea in the database', function () use ($validPayload) {
    $user = User::factory()->create();

    $this->actingAs($user)->post(route('feedback.store'), $validPayload());

    $this->assertDatabaseHas('ideas', [
        'user_id' => $user->id,
        'title' => 'Dark mode support',
        'description' => 'It would be great to have a dark mode option for the app.',
        'status' => 'under_review',
        'votes' => 0,
    ]);
});

it('auto-subscribes the author to their idea', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post(route('feedback.store'), [
        'title' => 'Dark mode support',
        'description' => 'It would be great to have a dark mode option for the app.',
    ]);

    $idea = \App\Models\Idea::firstWhere('title', 'Dark mode support');

    expect($idea->subscribers()->where('users.id', $user->id)->exists())->toBeTrue();
});

it('redirects to home with a flash message after submission', function () use ($validPayload) {
    $this->actingAs(User::factory()->create())
        ->post(route('feedback.store'), $validPayload())
        ->assertRedirect(route('dashboard'))
        ->assertSessionHas('status');
});

// ---------------------------------------------------------------------------
// Validation
// ---------------------------------------------------------------------------

it('requires a title', function () use ($validPayload) {
    $this->actingAs(User::factory()->create())
        ->post(route('feedback.store'), array_merge($validPayload(), ['title' => '']))
        ->assertSessionHasErrors('title');
});

it('requires a description', function () use ($validPayload) {
    $this->actingAs(User::factory()->create())
        ->post(route('feedback.store'), array_merge($validPayload(), ['description' => '']))
        ->assertSessionHasErrors('description');
});

it('rejects a title longer than 255 characters', function () use ($validPayload) {
    $this->actingAs(User::factory()->create())
        ->post(route('feedback.store'), array_merge($validPayload(), ['title' => str_repeat('a', 256)]))
        ->assertSessionHasErrors('title');
});

it('rejects a description longer than 5000 characters', function () use ($validPayload) {
    $this->actingAs(User::factory()->create())
        ->post(route('feedback.store'), array_merge($validPayload(), ['description' => str_repeat('a', 5001)]))
        ->assertSessionHasErrors('description');
});
