<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Device;
use App\Model\DeviceState;
use App\Model\Installation;

/**
 * Dane przykładowe. W zadaniu z bazą danych zastąpi je implementacja na PDO.
 */
final class InMemoryInstallationRepository implements InstallationRepositoryInterface
{
    /** @var array<int, Installation> */
    private array $installations;

    public function __construct()
    {
        $this->installations = [
            1 => new Installation(
                id: 1,
                clientName: 'Anna Nowak',
                siteName: 'Dom',
                address: 'ul. Lipowa 12, Kraków',
                type: 'Alarm, monitoring i sieć',
                installedAt: new \DateTimeImmutable('2025-03-14'),
                nextInspection: new \DateTimeImmutable('2026-11-14'),
                inspectionNote: 'wymiana akumulatora centrali',
                devices: [
                    new Device('Centrala alarmowa', 'Garaż, szafka techniczna', DeviceState::BatteryLow),
                    new Device('Czujnik ruchu', 'Salon, strefa 1', DeviceState::Ok),
                    new Device('Kamera IP – ogród', 'Elewacja tylna, kanał 3', DeviceState::Failure),
                    new Device('Kamera IP – wjazd', 'Elewacja przednia, kanał 1', DeviceState::Ok),
                    new Device('Rejestrator NVR', '8 kanałów, szafka techniczna', DeviceState::Ok),
                    new Device('Switch PoE', 'Szafka techniczna', DeviceState::Ok),
                ],
            ),
            2 => new Installation(
                id: 2,
                clientName: 'Jan Kowalski',
                siteName: null,
                address: 'ul. Polna 3, Skawina',
                type: 'System alarmowy',
                installedAt: new \DateTimeImmutable('2024-12-02'),
                nextInspection: new \DateTimeImmutable('2026-12-02'),
            ),
            3 => new Installation(
                id: 3,
                clientName: 'Sklep „Pod Dębem”',
                siteName: null,
                address: 'Rynek 4, Wieliczka',
                type: 'System alarmowy',
                installedAt: new \DateTimeImmutable('2024-11-21'),
                nextInspection: new \DateTimeImmutable('2026-11-21'),
            ),
        ];
    }

    public function findAll(): array
    {
        return array_values($this->installations);
    }

    public function find(int $id): ?Installation
    {
        return $this->installations[$id] ?? null;
    }
}
