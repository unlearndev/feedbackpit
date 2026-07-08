<?php

use App\Models\Idea;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

$validPayload = fn () => [
    'title' => 'Updated title',
    'description' => 'Updated description for the feedback.',
];

// ---------------------------------------------------------------------------
// Auth guard
// ---------------------------------------------------------------------------

it('redirects guests to login', function () use ($validPayload) {
    $idea = Idea::factory()->create();

    $this->put(route('feedback.update', $idea), $validPayload())
        ->assertRedirect(route('login'));
});

it('shows the edit form to the author', function () {
    $idea = Idea::factory()->create();

    $this->actingAs($idea->user)
        ->get(route('feedback.edit', $idea))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Ideas/Edit'));
});

// ---------------------------------------------------------------------------
// Authorization
// ---------------------------------------------------------------------------

it('forbids a non-author from viewing the edit form', function () {
    $idea = Idea::factory()->create();

    $this->actingAs(User::factory()->create())
        ->get(route('feedback.edit', $idea))
        ->assertForbidden();
});

it('forbids a non-author from updating', function () use ($validPayload) {
    $idea = Idea::factory()->create(['title' => 'Original title']);

    $this->actingAs(User::factory()->create())
        ->put(route('feedback.update', $idea), $validPayload())
        ->assertForbidden();

    $this->assertDatabaseHas('ideas', ['id' => $idea->id, 'title' => 'Original title']);
});

// ---------------------------------------------------------------------------
// Successful update
// ---------------------------------------------------------------------------

it('updates the idea for the author', function () use ($validPayload) {
    $idea = Idea::factory()->create();

    $this->actingAs($idea->user)
        ->put(route('feedback.update', $idea), $validPayload())
        ->assertRedirect(route('feedback.show', $idea))
        ->assertSessionHas('status');

    $this->assertDatabaseHas('ideas', [
        'id' => $idea->id,
        'title' => 'Updated title',
        'description' => 'Updated description for the feedback.',
    ]);
});

// ---------------------------------------------------------------------------
// Validation
// ---------------------------------------------------------------------------

it('requires a title', function () use ($validPayload) {
    $idea = Idea::factory()->create();

    $this->actingAs($idea->user)
        ->put(route('feedback.update', $idea), array_merge($validPayload(), ['title' => '']))
        ->assertSessionHasErrors('title');
});

it('requires a description', function () use ($validPayload) {
    $idea = Idea::factory()->create();

    $this->actingAs($idea->user)
        ->put(route('feedback.update', $idea), array_merge($validPayload(), ['description' => '']))
        ->assertSessionHasErrors('description');
});

it('rejects a title longer than 255 characters', function () use ($validPayload) {
    $idea = Idea::factory()->create();

    $this->actingAs($idea->user)
        ->put(route('feedback.update', $idea), array_merge($validPayload(), ['title' => str_repeat('a', 256)]))
        ->assertSessionHasErrors('title');
});

it('rejects a description longer than 5000 characters', function () use ($validPayload) {
    $idea = Idea::factory()->create();

    $this->actingAs($idea->user)
        ->put(route('feedback.update', $idea), array_merge($validPayload(), ['description' => str_repeat('a', 5001)]))
        ->assertSessionHasErrors('description');
});
