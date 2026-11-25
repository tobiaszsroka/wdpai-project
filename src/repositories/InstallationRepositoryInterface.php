<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Installation;

interface InstallationRepositoryInterface
{
    /** @return list<Installation> */
    public function findAll(): array;

    /** @return list<Installation> Instalacje jednego klienta. */
    public function findByClientId(int $clientId): array;

    public function find(int $id): ?Installation;
}
