<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine if the user can view the target user
     */
    public function view(User $user, User $targetUser): bool
    {
        return $user->isAdmin() || $user->id === $targetUser->id;
    }

    /**
     * Determine if the user can update the target user
     */
    public function update(User $user, User $targetUser): bool
    {
        return $user->isAdmin() || $user->id === $targetUser->id;
    }

    /**
     * Determine if the user can delete the target user
     */
    public function delete(User $user, User $targetUser): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can manage users
     */
    public function manage(User $user): bool
    {
        return $user->isAdmin();
    }
}
