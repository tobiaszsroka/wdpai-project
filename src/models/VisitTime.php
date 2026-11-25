<?php

declare(strict_types=1);

namespace App\Model;

/**
 * Value Object: godzina wizyty. Nie ma tożsamości, liczy się wartość.
 * Jest niemutowalny i waliduje dane w konstruktorze.
 */
final class VisitTime implements \Stringable
{
    private function __construct(
        private readonly int $hour,
        private readonly int $minute,
    ) {
    }

    /** Przyjmuje „H:MM”, „HH:MM” lub „HH:MM:SS” (format kolumny TIME w PostgreSQL). */
    public static function fromString(string $value): self
    {
        if (!preg_match('/^([01]?\d|2[0-3]):([0-5]\d)(?::[0-5]\d)?$/', $value, $matches)) {
            throw new \InvalidArgumentException('Invalid visit time: ' . $value);
        }

        return new self((int) $matches[1], (int) $matches[2]);
    }

    public function equals(self $other): bool
    {
        return $this->hour === $other->hour && $this->minute === $other->minute;
    }

    public function __toString(): string
    {
        return sprintf('%02d:%02d', $this->hour, $this->minute);
    }
}
