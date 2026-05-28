<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('updates first and last name when both are provided', function () {
    $user = User::factory()->create([
        'first_name' => 'Old',
        'last_name' => 'Name',
        'email' => 'jane@example.com',
    ]);

    $this->actingAs($user)
        ->put('/account/settings', [
            'first_name' => 'New',
            'last_name' => 'Person',
            'email' => 'jane@example.com',
        ])
        ->assertSessionHasNoErrors();

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'first_name' => 'New',
        'last_name' => 'Person',
    ]);
});

it('rejects an empty first name', function () {
    $user = User::factory()->create([
        'first_name' => 'Jane',
        'last_name' => 'Doe',
        'email' => 'jane@example.com',
    ]);

    $this->actingAs($user)
        ->put('/account/settings', [
            'first_name' => '',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
        ])
        ->assertSessionHasErrors('first_name');

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'first_name' => 'Jane',
        'last_name' => 'Doe',
    ]);
});

it('rejects an empty last name', function () {
    $user = User::factory()->create([
        'first_name' => 'Jane',
        'last_name' => 'Doe',
        'email' => 'jane@example.com',
    ]);

    $this->actingAs($user)
        ->put('/account/settings', [
            'first_name' => 'Jane',
            'last_name' => '',
            'email' => 'jane@example.com',
        ])
        ->assertSessionHasErrors('last_name');

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'first_name' => 'Jane',
        'last_name' => 'Doe',
    ]);
});
