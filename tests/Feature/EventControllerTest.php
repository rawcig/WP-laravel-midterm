<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Event;

uses(RefreshDatabase::class);

test('can view create event page', function () {
    $response = $this->get('/create-event');

    $response->assertStatus(200);
});

test('can create event', function () {
    $response = $this->post(route('events.store'), [
        'title' => 'Test Event',
        'description' => 'This is a test event',
        'date' => now()->addDay()->format('Y-m-d H:i:s'),
        'location' => 'Test Location',
    ]);

    $response->assertRedirect(); // Expecting a redirect after successful creation
    $this->assertDatabaseHas('events', [
        'title' => 'Test Event',
        'description' => 'This is a test event',
        'location' => 'Test Location',
    ]);
});

test('can view events list', function () {
    $response = $this->get('/events');

    $response->assertStatus(200);
});

test('validation fails with invalid data', function () {
    $response = $this->post(route('events.store'), [
        'title' => '', // Required field
        'description' => '', // Required field
        'date' => 'invalid-date', // Invalid date
    ]);

    $response->assertSessionHasErrors(['title', 'description', 'date']);
});
