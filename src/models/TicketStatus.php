<?php

declare(strict_types=1);

namespace App\Model;

enum TicketStatus: string
{
    case New = 'new';
    case Scheduled = 'scheduled';
    case Assigned = 'assigned';
    case InProgress = 'in_progress';
    case WaitingForPart = 'waiting_for_part';
    case Done = 'done';

    public function label(): string
    {
        return match ($this) {
            self::New => 'Nowe',
            self::Scheduled => 'Zaplanowane',
            self::Assigned => 'Przypisane',
            self::InProgress => 'W toku',
            self::WaitingForPart => 'Oczekuje na część',
            self::Done => 'Zakończone',
        };
    }

    /** Wariant koloru plakietki (klasa CSS chip-*). */
    public function tone(): string
    {
        return match ($this) {
            self::New, self::Scheduled => 'info',
            self::Assigned, self::InProgress, self::WaitingForPart => 'warn',
            self::Done => 'ok',
        };
    }
}
