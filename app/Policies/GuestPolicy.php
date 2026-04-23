<?php

namespace App\Policies;

use App\Models\Guest;
use App\Models\User;

class GuestPolicy
{
    /**
     * Determine if the user can view the guest
     */
    public function view(User $user, Guest $guest): bool
    {
        // Admin and organizers can view all guests
        return $user->isAdmin() || $user->isOrganizer();
    }

    /**
     * Determine if the user can create guests
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isOrganizer();
    }

    /**
     * Determine if the user can update the guest
     */
    public function update(User $user, Guest $guest): bool
    {
        return $user->isAdmin() || $user->isOrganizer();
    }

    /**
     * Determine if the user can delete the guest
     */
    public function delete(User $user, Guest $guest): bool
    {
        return $user->isAdmin() || $user->isOrganizer();
    }

    /**
     * Determine if the user can check in the guest
     */
    public function checkIn(User $user, Guest $guest): bool
    {
        return $user->isAdmin() || $user->isOrganizer();
    }

    /**
     * Determine if the user can check out the guest
     */
    public function checkOut(User $user, Guest $guest): bool
    {
        return $user->isAdmin() || $user->isOrganizer();
    }
}
