<?php

declare(strict_types=1);

namespace App\Model;

/**
 * Urządzenie w instalacji. Celowo bez haseł i kodów alarmowych.
 */
final class Device
{
    public function __construct(
        private readonly string $name,
        private readonly string $place,
        private readonly DeviceState $state,
    ) {
        if (trim($name) === '') {
            throw new \InvalidArgumentException('Device name must not be empty.');
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPlace(): string
    {
        return $this->place;
    }

    public function getState(): DeviceState
    {
        return $this->state;
    }
}
