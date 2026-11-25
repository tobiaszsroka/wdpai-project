<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\ReportTicketData;
use App\Model\Ticket;
use App\Model\TicketStatus;
use App\Repository\InstallationRepositoryInterface;
use App\Repository\TicketRepositoryInterface;

final class TicketService
{
    public const CATEGORIES = [
        'Kamera nie działa',
        'Alarm zgłasza błąd',
        'Brak połączenia z siecią',
        'Inne',
    ];

    public const DESCRIPTION_MIN_LENGTH = 10;
    public const DESCRIPTION_MAX_LENGTH = 2000;

    public function __construct(
        private readonly TicketRepositoryInterface $tickets,
        private readonly InstallationRepositoryInterface $installations,
    ) {
    }

    /**
     * Waliduje zgłoszenie klienta i zapisuje je jako nowe.
     *
     * @throws ValidationException gdy dane są niepoprawne
     */
    public function report(ReportTicketData $data): Ticket
    {
        $installation = $this->installations->find($data->installationId);
        $description = trim($data->description);
        $errors = [];

        if ($installation === null) {
            $errors['installation'] = 'Wybierz instalację z listy.';
        }

        if (!in_array($data->category, self::CATEGORIES, true)) {
            $errors['category'] = 'Wybierz kategorię z listy.';
        }

        $length = mb_strlen($description);
        if ($length < self::DESCRIPTION_MIN_LENGTH) {
            $errors['description'] = 'Opisz usterkę w co najmniej ' . self::DESCRIPTION_MIN_LENGTH . ' znakach.';
        } elseif ($length > self::DESCRIPTION_MAX_LENGTH) {
            $errors['description'] = 'Opis może mieć najwyżej ' . self::DESCRIPTION_MAX_LENGTH . ' znaków.';
        }

        if ($errors !== [] || $installation === null) {
            throw new ValidationException($errors);
        }

        $ticket = new Ticket(
            id: null,
            installationId: $installation->getId(),
            clientName: $installation->getClientName(),
            category: $data->category,
            title: $data->category,
            place: $installation->getClientName() . ' · ' . $installation->getAddress(),
            description: $description,
            createdAt: new \DateTimeImmutable(),
            status: TicketStatus::New,
        );
        $this->tickets->save($ticket);

        return $ticket;
    }
}
