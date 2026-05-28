<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// ---------------------------------------------------------------------------
// Successful name update
// ---------------------------------------------------------------------------

it('updates the name to a valid value', function () {
    $user = User::factory()->create(['name' => 'Old Name', 'email' => 'user@example.com']);

    $this->actingAs($user)
        ->put('/account/settings', ['name' => 'New Name', 'email' => $user->email])
        ->assertSessionHasNoErrors();

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'New Name',
    ]);
});

// ---------------------------------------------------------------------------
// Validation
// ---------------------------------------------------------------------------

it('returns a validation error when the name is empty', function () {
    $user = User::factory()->create(['name' => 'Old Name']);

    $this->actingAs($user)
        ->put('/account/settings', ['name' => '', 'email' => $user->email])
        ->assertSessionHasErrors('name');

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Old Name',
    ]);
});

it('returns a validation error when the name is longer than 255 characters', function () {
    $user = User::factory()->create(['name' => 'Old Name']);

    $this->actingAs($user)
        ->put('/account/settings', ['name' => str_repeat('a', 256), 'email' => $user->email])
        ->assertSessionHasErrors('name');

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Old Name',
    ]);
});
