<?php

declare(strict_types=1);

namespace App\Model;

enum UserRole: string
{
    case Client = 'client';
    case Technician = 'technician';
    case Admin = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::Client => 'Klient',
            self::Technician => 'Technik',
            self::Admin => 'Administrator',
        };
    }

    /** Strona startowa po zalogowaniu. */
    public function homePath(): string
    {
        return match ($this) {
            self::Client => '/m/report',
            self::Technician => '/m/tasks',
            self::Admin => '/dashboard',
        };
    }
}
