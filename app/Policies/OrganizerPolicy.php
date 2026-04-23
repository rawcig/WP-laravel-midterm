<?php

namespace App\Policies;

use App\Models\Organizer;
use App\Models\User;

class OrganizerPolicy
{
    /**
     * Determine if the user can view the organizer
     */
    public function view(User $user, Organizer $organizer): bool
    {
        return true; // All users can view organizers
    }

    /**
     * Determine if the user can create organizers
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can update the organizer
     */
    public function update(User $user, Organizer $organizer): bool
    {
        return $user->isAdmin() || $user->id === $organizer->user_id;
    }

    /**
     * Determine if the user can delete the organizer
     */
    public function delete(User $user, Organizer $organizer): bool
    {
        return $user->isAdmin();
    }
}
