<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Ticket;
use App\Model\TicketStatus;

interface TicketRepositoryInterface
{
    /** @return list<Ticket> Od najnowszego zgłoszenia, bez historii zmian. */
    public function findAll(): array;

    /** Zgłoszenie razem z historią zmian. */
    public function find(int $id): ?Ticket;

    /** @return list<Ticket> Zgłoszenia przypisane technikowi, według godziny wizyty. */
    public function findByTechnician(string $technician): array;

    /** Zapisuje nowe zgłoszenie i ustawia jego identyfikator nadany przez bazę. */
    public function save(Ticket $ticket): void;

    /** Zmienia status i dopisuje wpis do historii w jednej transakcji. */
    public function updateStatus(int $id, TicketStatus $status): void;

    public function delete(int $id): void;
}
