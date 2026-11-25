<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Ticket;
use App\Model\TicketStatus;
use App\Model\VisitTime;
use DateTimeImmutable;
use PDO;

final class PdoTicketRepository implements TicketRepositoryInterface
{
    private const SELECT = "SELECT t.id, t.installation_id, c.name AS client_name, t.category, t.title,
                c.name || ' · ' || i.address AS place, t.description, t.created_at, t.status,
                t.urgent, t.technician, to_char(t.visit_time, 'HH24:MI') AS visit_time
            FROM tickets t
            JOIN installations i ON i.id = t.installation_id
            JOIN clients c ON c.id = i.client_id";

    public function __construct(private readonly PDO $database)
    {
    }

    public function findAll(): array
    {
        $statement = $this->database->query(self::SELECT . ' ORDER BY t.created_at DESC, t.id DESC');

        return array_map($this->mapRowToTicket(...), $statement->fetchAll());
    }

    public function find(int $id): ?Ticket
    {
        $statement = $this->database->prepare(self::SELECT . ' WHERE t.id = :id');
        $statement->execute(['id' => $id]);
        $row = $statement->fetch();

        return $row === false ? null : $this->mapRowToTicket($row, $this->findHistory($id));
    }

    public function findByTechnician(string $technician): array
    {
        $statement = $this->database->prepare(
            self::SELECT . ' WHERE t.technician = :technician AND t.visit_time IS NOT NULL
                ORDER BY t.visit_time',
        );
        $statement->execute(['technician' => $technician]);

        return array_map($this->mapRowToTicket(...), $statement->fetchAll());
    }

    public function save(Ticket $ticket): void
    {
        $statement = $this->database->prepare(
            'INSERT INTO tickets (installation_id, category, title, description, status, urgent, technician)
             VALUES (:installation_id, :category, :title, :description, :status, :urgent, :technician)
             RETURNING id',
        );
        $statement->bindValue('installation_id', $ticket->getInstallationId(), PDO::PARAM_INT);
        $statement->bindValue('category', $ticket->getCategory());
        $statement->bindValue('title', $ticket->getTitle());
        $statement->bindValue('description', $ticket->getDescription());
        $statement->bindValue('status', $ticket->getStatus()->value);
        $statement->bindValue('urgent', $ticket->isUrgent(), PDO::PARAM_BOOL);
        $statement->bindValue('technician', $ticket->getTechnician());
        $statement->execute();

        $ticket->setId((int) $statement->fetchColumn());
    }

    public function updateStatus(int $id, TicketStatus $status): void
    {
        $this->database->beginTransaction();

        try {
            $update = $this->database->prepare(
                'UPDATE tickets SET status = :status, updated_at = CURRENT_TIMESTAMP WHERE id = :id',
            );
            $update->execute(['status' => $status->value, 'id' => $id]);

            $history = $this->database->prepare(
                'INSERT INTO ticket_history (ticket_id, description) VALUES (:id, :description)',
            );
            $history->execute(['id' => $id, 'description' => 'zmieniono status na: ' . $status->label()]);

            $this->database->commit();
        } catch (\Throwable $exception) {
            $this->database->rollBack();

            throw $exception;
        }
    }

    public function delete(int $id): void
    {
        $statement = $this->database->prepare('DELETE FROM tickets WHERE id = :id');
        $statement->execute(['id' => $id]);
    }

    /** @return list<array{0: DateTimeImmutable, 1: string}> */
    private function findHistory(int $ticketId): array
    {
        $statement = $this->database->prepare(
            'SELECT occurred_at, description FROM ticket_history
             WHERE ticket_id = :id ORDER BY occurred_at DESC, id DESC',
        );
        $statement->execute(['id' => $ticketId]);

        return array_map(
            static fn (array $row): array => [new DateTimeImmutable((string) $row['occurred_at']), (string) $row['description']],
            $statement->fetchAll(),
        );
    }

    /**
     * @param array<string, mixed> $row
     * @param list<array{0: DateTimeImmutable, 1: string}> $history
     */
    private function mapRowToTicket(array $row, array $history = []): Ticket
    {
        return new Ticket(
            id: (int) $row['id'],
            installationId: (int) $row['installation_id'],
            clientName: (string) $row['client_name'],
            category: (string) $row['category'],
            title: (string) $row['title'],
            place: (string) $row['place'],
            description: (string) $row['description'],
            createdAt: new DateTimeImmutable((string) $row['created_at']),
            status: TicketStatus::from((string) $row['status']),
            urgent: (bool) $row['urgent'],
            technician: $row['technician'] === null ? null : (string) $row['technician'],
            visitTime: $row['visit_time'] === null ? null : VisitTime::fromString((string) $row['visit_time']),
            history: $history,
        );
    }
}
