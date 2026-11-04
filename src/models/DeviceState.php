<?php

declare(strict_types=1);

namespace App\Model;

enum DeviceState: string
{
    case Ok = 'ok';
    case BatteryLow = 'battery_low';
    case Failure = 'failure';

    public function label(): string
    {
        return match ($this) {
            self::Ok => 'OK',
            self::BatteryLow => 'Akumulator',
            self::Failure => 'Awaria',
        };
    }

    /** Wariant koloru plakietki (klasa CSS chip-*). */
    public function tone(): string
    {
        return match ($this) {
            self::Ok => 'ok',
            self::BatteryLow => 'warn',
            self::Failure => 'bad',
        };
    }
}
