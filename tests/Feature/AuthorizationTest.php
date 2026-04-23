<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use App\Models\Guest;
use App\Models\Organizer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $organizer;
    private User $user;
    private Event $event;
    private Organizer $organizerModel;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test users
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->organizer = User::factory()->create(['role' => 'organizer']);
        $this->user = User::factory()->create(['role' => 'user']);

        // Create organizer model
        $this->organizerModel = Organizer::factory()->create();

        // Create event
        $this->event = Event::factory()->create(['organizer_id' => $this->organizerModel->id]);
    }

    // ============ EVENT POLICY TESTS ============

    /**
     * Test admin can create events
     */
    public function test_admin_can_create_event(): void
    {
        $this->actingAs($this->admin)
            ->get(route('create-event'))
            ->assertSuccessful();
    }

    /**
     * Test organizer can create events
     */
    public function test_organizer_can_create_event(): void
    {
        $this->actingAs($this->organizer)
            ->get(route('create-event'))
            ->assertSuccessful();
    }

    /**
     * Test regular user cannot create events
     */
    public function test_user_cannot_create_event(): void
    {
        $this->actingAs($this->user)
            ->get(route('create-event'))
            ->assertForbidden();
    }

    /**
     * Test organizer can edit own event
     */
    public function test_organizer_can_edit_own_event(): void
    {
        $this->actingAs($this->organizer)
            ->get(route('events.edit', $this->event))
            ->assertSuccessful();
    }

    /**
     * Test organizer cannot edit other's event
     */
    public function test_organizer_cannot_edit_others_event(): void
    {
        $otherOrganizer = User::factory()->create(['role' => 'organizer']);
        $otherOrganizerModel = Organizer::factory()->create(['user_id' => $otherOrganizer->id]);
        $otherEvent = Event::factory()->create(['organizer_id' => $otherOrganizerModel->id]);

        $this->actingAs($this->organizer)
            ->get(route('events.edit', $otherEvent))
            ->assertForbidden();
    }

    /**
     * Test admin can edit any event
     */
    public function test_admin_can_edit_any_event(): void
    {
        $this->actingAs($this->admin)
            ->get(route('events.edit', $this->event))
            ->assertSuccessful();
    }

    /**
     * Test organizer can delete own event
     */
    public function test_organizer_can_delete_own_event(): void
    {
        $response = $this->actingAs($this->organizer)
            ->delete(route('events.destroy', $this->event));

        $this->assertDatabaseMissing('events', ['id' => $this->event->id]);
    }

    /**
     * Test organizer cannot delete other's event
     */
    public function test_organizer_cannot_delete_others_event(): void
    {
        $otherOrganizer = User::factory()->create(['role' => 'organizer']);
        $otherOrganizerModel = Organizer::factory()->create(['user_id' => $otherOrganizer->id]);
        $otherEvent = Event::factory()->create(['organizer_id' => $otherOrganizerModel->id]);

        $this->actingAs($this->organizer)
            ->delete(route('events.destroy', $otherEvent))
            ->assertForbidden();
    }

    /**
     * Test organizer can view guests in own event
     */
    public function test_organizer_can_view_guests_in_own_event(): void
    {
        $this->actingAs($this->organizer)
            ->get(route('events.guests', $this->event))
            ->assertSuccessful();
    }

    /**
     * Test organizer cannot view guests in other's event
     */
    public function test_organizer_cannot_view_guests_in_others_event(): void
    {
        $otherOrganizer = User::factory()->create(['role' => 'organizer']);
        $otherOrganizerModel = Organizer::factory()->create(['user_id' => $otherOrganizer->id]);
        $otherEvent = Event::factory()->create(['organizer_id' => $otherOrganizerModel->id]);

        $this->actingAs($this->organizer)
            ->get(route('events.guests', $otherEvent))
            ->assertForbidden();
    }

    // ============ GUEST POLICY TESTS ============

    /**
     * Test organizer can update guest in own event
     */
    public function test_organizer_can_update_guest_in_own_event(): void
    {
        $guest = Guest::factory()->create(['event_id' => $this->event->id]);

        $response = $this->actingAs($this->organizer)
            ->put(route('guests.update', $guest), [
                'name' => 'Updated Name',
                'email' => 'updated@example.com',
                'event_id' => $this->event->id,
                'status' => 'confirmed',
                'ticket_count' => 1,
            ]);

        $this->assertDatabaseHas('guests', ['id' => $guest->id, 'name' => 'Updated Name']);
    }

    /**
     * Test organizer cannot update guest in other's event
     */
    public function test_organizer_cannot_update_guest_in_others_event(): void
    {
        $otherOrganizer = User::factory()->create(['role' => 'organizer']);
        $otherOrganizerModel = Organizer::factory()->create(['user_id' => $otherOrganizer->id]);
        $otherEvent = Event::factory()->create(['organizer_id' => $otherOrganizerModel->id]);
        $guest = Guest::factory()->create(['event_id' => $otherEvent->id]);

        $this->actingAs($this->organizer)
            ->put(route('guests.update', $guest), [
                'name' => 'Updated Name',
                'email' => 'updated@example.com',
                'event_id' => $otherEvent->id,
                'status' => 'confirmed',
                'ticket_count' => 1,
            ])
            ->assertForbidden();
    }

    /**
     * Test organizer can check in guest in own event
     */
    public function test_organizer_can_checkin_guest_in_own_event(): void
    {
        $guest = Guest::factory()->create(['event_id' => $this->event->id, 'checked_in' => false]);

        $this->actingAs($this->organizer)
            ->post(route('guests.check-in', $guest))
            ->assertRedirect();

        $this->assertTrue($guest->refresh()->checked_in);
    }

    /**
     * Test organizer cannot check in guest in other's event
     */
    public function test_organizer_cannot_checkin_guest_in_others_event(): void
    {
        $otherOrganizer = User::factory()->create(['role' => 'organizer']);
        $otherOrganizerModel = Organizer::factory()->create(['user_id' => $otherOrganizer->id]);
        $otherEvent = Event::factory()->create(['organizer_id' => $otherOrganizerModel->id]);
        $guest = Guest::factory()->create(['event_id' => $otherEvent->id, 'checked_in' => false]);

        $this->actingAs($this->organizer)
            ->post(route('guests.check-in', $guest))
            ->assertForbidden();
    }

    // ============ ORGANIZER POLICY TESTS ============

    /**
     * Test admin can create organizer
     */
    public function test_admin_can_create_organizer(): void
    {
        $this->actingAs($this->admin)
            ->get(route('organizer.create'))
            ->assertSuccessful();
    }

    /**
     * Test organizer cannot create organizer
     */
    public function test_organizer_cannot_create_organizer(): void
    {
        $this->actingAs($this->organizer)
            ->get(route('organizer.create'))
            ->assertForbidden();
    }

    /**
     * Test admin can delete organizer
     */
    public function test_admin_can_delete_organizer(): void
    {
        $org = Organizer::factory()->create();

        $this->actingAs($this->admin)
            ->delete(route('organizer.destroy', $org))
            ->assertRedirect();

        $this->assertDatabaseMissing('organizers', ['id' => $org->id]);
    }

    /**
     * Test organizer cannot delete organizer
     */
    public function test_organizer_cannot_delete_organizer(): void
    {
        $org = Organizer::factory()->create();

        $this->actingAs($this->organizer)
            ->delete(route('organizer.destroy', $org))
            ->assertForbidden();
    }

    // ============ USER POLICY TESTS ============

    /**
     * Test user can edit own profile
     */
    public function test_user_can_edit_own_profile(): void
    {
        $this->actingAs($this->user)
            ->put(route('profile.update'), [
                'name' => 'Updated Name',
                'email' => $this->user->email,
                'phone' => '1234567890',
                'bio' => 'Updated bio',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('users', ['id' => $this->user->id, 'name' => 'Updated Name']);
    }

    /**
     * Test admin can edit any user profile
     */
    public function test_admin_can_edit_any_user_profile(): void
    {
        $this->actingAs($this->admin)
            ->put(route('profile.update'), [
                'name' => 'Updated Name',
                'email' => $this->admin->email,
                'phone' => '1234567890',
                'bio' => 'Updated bio',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('users', ['id' => $this->admin->id, 'name' => 'Updated Name']);
    }
}
