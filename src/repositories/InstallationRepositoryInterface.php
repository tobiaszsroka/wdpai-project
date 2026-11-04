<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Installation;

interface InstallationRepositoryInterface
{
    /** @return list<Installation> */
    public function findAll(): array;

    public function find(int $id): ?Installation;
}
