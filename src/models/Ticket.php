<?php

declare(strict_types=1);

namespace App\Model;

final class Ticket
{
    /**
     * @param list<array{0: \DateTimeImmutable, 1: string}> $history Wpisy od najnowszego.
     */
    public function __construct(
        private readonly int $id,
        private readonly string $clientName,
        private readonly string $category,
        private readonly string $title,
        private readonly string $place,
        private readonly string $description,
        private readonly \DateTimeImmutable $createdAt,
        private readonly TicketStatus $status,
        private readonly bool $urgent = false,
        private readonly ?string $technician = null,
        private readonly ?string $visitTime = null,
        private readonly array $history = [],
    ) {
        if ($id <= 0) {
            throw new \InvalidArgumentException('Ticket id must be positive.');
        }

        if (trim($title) === '' || trim($clientName) === '') {
            throw new \InvalidArgumentException('Ticket title and client name must not be empty.');
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

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPlace(): string
    {
        return $this->place;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getStatus(): TicketStatus
    {
        return $this->status;
    }

    public function isUrgent(): bool
    {
        return $this->urgent && $this->status !== TicketStatus::Done;
    }

    public function getTechnician(): ?string
    {
        return $this->technician;
    }

    public function getVisitTime(): ?string
    {
        return $this->visitTime;
    }

    /** @return list<array{0: \DateTimeImmutable, 1: string}> */
    public function getHistory(): array
    {
        return $this->history;
    }

    /** Tekst plakietki na listach: „Pilne” ma pierwszeństwo przed statusem. */
    public function getBadgeLabel(): string
    {
        return $this->isUrgent() ? 'Pilne' : $this->status->label();
    }

    public function getBadgeTone(): string
    {
        return $this->isUrgent() ? 'bad' : $this->status->tone();
    }
}
