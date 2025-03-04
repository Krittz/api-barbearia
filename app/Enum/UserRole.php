<?php

namespace App\Enum;

enum UserRole: string
{
    case ADMIN = 'admin';
    case OWNER = 'owner';
    case CUSTOMER = 'customer';
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
