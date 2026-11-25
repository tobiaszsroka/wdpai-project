<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Device;
use App\Model\DeviceState;
use App\Model\Installation;
use DateTimeImmutable;
use PDO;

final class PdoInstallationRepository implements InstallationRepositoryInterface
{
    private const SELECT = 'SELECT i.id, i.client_id, c.name AS client_name, i.site_name, i.address, i.type,
                i.installed_at, i.next_inspection, i.inspection_note
            FROM installations i
            JOIN clients c ON c.id = i.client_id';

    public function __construct(private readonly PDO $database)
    {
    }

    public function findAll(): array
    {
        $statement = $this->database->query(self::SELECT . ' ORDER BY i.id');

        return array_map($this->mapRowToInstallation(...), $statement->fetchAll());
    }

    public function findByClientId(int $clientId): array
    {
        $statement = $this->database->prepare(self::SELECT . ' WHERE i.client_id = :client_id ORDER BY i.id');
        $statement->execute(['client_id' => $clientId]);

        return array_map($this->mapRowToInstallation(...), $statement->fetchAll());
    }

    public function find(int $id): ?Installation
    {
        $statement = $this->database->prepare(self::SELECT . ' WHERE i.id = :id');
        $statement->execute(['id' => $id]);
        $row = $statement->fetch();

        return $row === false ? null : $this->mapRowToInstallation($row, $this->findDevices($id));
    }

    /** @return list<Device> */
    private function findDevices(int $installationId): array
    {
        $statement = $this->database->prepare(
            'SELECT name, place, state FROM devices WHERE installation_id = :id ORDER BY id',
        );
        $statement->execute(['id' => $installationId]);

        return array_map(
            static fn (array $row): Device => new Device(
                (string) $row['name'],
                (string) $row['place'],
                DeviceState::from((string) $row['state']),
            ),
            $statement->fetchAll(),
        );
    }

    /**
     * @param array<string, mixed> $row
     * @param list<Device> $devices
     */
    private function mapRowToInstallation(array $row, array $devices = []): Installation
    {
        return new Installation(
            id: (int) $row['id'],
            clientId: (int) $row['client_id'],
            clientName: (string) $row['client_name'],
            siteName: $row['site_name'] === null ? null : (string) $row['site_name'],
            address: (string) $row['address'],
            type: (string) $row['type'],
            installedAt: new DateTimeImmutable((string) $row['installed_at']),
            nextInspection: new DateTimeImmutable((string) $row['next_inspection']),
            inspectionNote: $row['inspection_note'] === null ? null : (string) $row['inspection_note'],
            devices: $devices,
        );
    }
}
