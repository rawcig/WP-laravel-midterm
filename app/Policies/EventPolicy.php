<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    /**
     * Determine if the user can view the event
     */
    public function view(User $user, Event $event): bool
    {
        return true; // All authenticated users can view events
    }

    /**
     * Determine if the user can create events
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isOrganizer();
    }

    /**
     * Determine if the user can update the event
     */
    public function update(User $user, Event $event): bool
    {
        return $user->isAdmin() || $user->isOrganizer();
    }

    /**
     * Determine if the user can delete the event
     */
    public function delete(User $user, Event $event): bool
    {
        return $user->isAdmin() || $user->isOrganizer();
    }

    /**
     * Determine if the user can view event guests
     */
    public function viewGuests(User $user, Event $event): bool
    {
        return $user->isAdmin() || $user->isOrganizer();
    }

    /**
     * Determine if the user can export guests
     */
    public function exportGuests(User $user, Event $event): bool
    {
        return $user->isAdmin() || $user->isOrganizer();
    }

    /**
     * Determine if the user can view event reports
     */
    public function viewReports(User $user, Event $event): bool
    {
        return $user->isAdmin() || $user->isOrganizer();
    }
}
