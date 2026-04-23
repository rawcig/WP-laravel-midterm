<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Organizer = 'organizer';
    case User = 'user';

    /**
     * Get the label for the role
     */
    public function label(): string
    {
        return match($this) {
            self::Admin => 'Administrator',
            self::Organizer => 'Event Organizer',
            self::User => 'Regular User',
        };
    }

    /**
     * Get all roles
     */
    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    /**
     * Check if this is admin role
     */
    public function isAdmin(): bool
    {
        return $this === self::Admin;
    }

    /**
     * Check if this is organizer role
     */
    public function isOrganizer(): bool
    {
        return $this === self::Organizer;
    }
}
