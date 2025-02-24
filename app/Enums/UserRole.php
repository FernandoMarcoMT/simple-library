<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = '1';
    case User = '2';

    // Optional: Add helper methods
    public function isEditable(): bool
    {
        return in_array($this, [self::Admin, self::User]);
    }
}
