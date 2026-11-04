<?php

declare(strict_types=1);

namespace App\Model;

final class Installation
{
    /**
     * @param list<Device> $devices
     */
    public function __construct(
        private readonly int $id,
        private readonly string $clientName,
        private readonly ?string $siteName,
        private readonly string $address,
        private readonly string $type,
        private readonly \DateTimeImmutable $installedAt,
        private readonly \DateTimeImmutable $nextInspection,
        private readonly ?string $inspectionNote = null,
        private readonly array $devices = [],
    ) {
        if ($id <= 0) {
            throw new \InvalidArgumentException('Installation id must be positive.');
        }

        if (trim($clientName) === '' || trim($address) === '') {
            throw new \InvalidArgumentException('Client name and address must not be empty.');
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getClientName(): string
    {
        return $this->clientName;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    /** Nazwa miejsca z adresem, np. „Dom, ul. Lipowa 12, Kraków”. */
    public function getTitle(): string
    {
        return $this->siteName === null ? $this->address : $this->siteName . ', ' . $this->address;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getInstalledAt(): \DateTimeImmutable
    {
        return $this->installedAt;
    }

    public function getNextInspection(): \DateTimeImmutable
    {
        return $this->nextInspection;
    }

    public function getInspectionNote(): ?string
    {
        return $this->inspectionNote;
    }

    /** @return list<Device> */
    public function getDevices(): array
    {
        return $this->devices;
    }

    /** Liczba dni do przeglądu; wartość ujemna oznacza przegląd po terminie. */
    public function daysUntilInspection(\DateTimeImmutable $today): int
    {
        return (int) $today->setTime(0, 0)->diff($this->nextInspection->setTime(0, 0))->format('%r%a');
    }
}
