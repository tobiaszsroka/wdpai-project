<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Ticket;

interface TicketRepositoryInterface
{
    /** @return list<Ticket> Od najnowszego zgłoszenia. */
    public function findAll(): array;

    public function find(int $id): ?Ticket;

    /** @return list<Ticket> Zgłoszenia przypisane technikowi, według godziny wizyty. */
    public function findByTechnician(string $technician): array;
}
