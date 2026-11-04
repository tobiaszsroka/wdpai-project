<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Ticket;
use App\Model\TicketStatus;

/**
 * Dane przykładowe. W zadaniu z bazą danych zastąpi je implementacja na PDO.
 */
final class InMemoryTicketRepository implements TicketRepositoryInterface
{
    /** @var list<Ticket> */
    private array $tickets;

    public function __construct()
    {
        $this->tickets = [
            new Ticket(
                id: 1045,
                clientName: 'Biuro Lex',
                category: 'Brak połączenia z siecią',
                title: 'Konfiguracja sieci i kamer IP',
                place: 'Biuro Lex · ul. Długa 21, Kraków',
                description: 'Konfiguracja sieci i dodanie kamer IP do rejestratora.',
                createdAt: new \DateTimeImmutable('2026-11-01 10:20'),
                status: TicketStatus::Scheduled,
                technician: 'Piotr Wiśniewski',
                visitTime: '16:00',
            ),
            new Ticket(
                id: 1044,
                clientName: 'Jan Kowalski',
                category: 'Alarm zgłasza błąd',
                title: 'Wymiana akumulatora w centrali',
                place: 'Jan Kowalski · ul. Polna 3, Skawina',
                description: 'Centrala sygnalizuje niski poziom akumulatora.',
                createdAt: new \DateTimeImmutable('2026-10-31 09:30'),
                status: TicketStatus::InProgress,
                technician: 'Piotr Wiśniewski',
                visitTime: '14:00',
            ),
            new Ticket(
                id: 1043,
                clientName: 'Sklep „Pod Dębem”',
                category: 'Inne',
                title: 'Przegląd roczny systemu alarmowego',
                place: 'Sklep „Pod Dębem” · Rynek 4, Wieliczka',
                description: 'Coroczny przegląd systemu alarmowego.',
                createdAt: new \DateTimeImmutable('2026-10-30 08:00'),
                status: TicketStatus::Scheduled,
                technician: 'Piotr Wiśniewski',
                visitTime: '11:30',
            ),
            new Ticket(
                id: 1042,
                clientName: 'Anna Nowak',
                category: 'Kamera nie działa',
                title: 'Kamera nie łączy się z rejestratorem',
                place: 'Anna Nowak · ul. Lipowa 12, Kraków',
                description: 'Kamera od strony ogrodu od wczoraj wieczorem pokazuje czarny obraz. Pozostałe trzy kamery działają normalnie.',
                createdAt: new \DateTimeImmutable('2026-11-01 21:15'),
                status: TicketStatus::Assigned,
                urgent: true,
                technician: 'Piotr Wiśniewski',
                visitTime: '09:00',
                history: [
                    [new \DateTimeImmutable('2026-11-02 07:40'), 'przypisano do technika'],
                    [new \DateTimeImmutable('2026-11-01 21:15'), 'zgłoszenie utworzone przez klienta'],
                ],
            ),
            new Ticket(
                id: 1041,
                clientName: 'Biuro Lex',
                category: 'Brak połączenia z siecią',
                title: 'Brak połączenia z rejestratorem',
                place: 'Biuro Lex · ul. Długa 21, Kraków',
                description: 'Rejestrator nie jest widoczny w sieci biura.',
                createdAt: new \DateTimeImmutable('2026-10-31 14:02'),
                status: TicketStatus::InProgress,
                technician: 'Tomasz Lis',
            ),
            new Ticket(
                id: 1040,
                clientName: 'Jan Kowalski',
                category: 'Alarm zgłasza błąd',
                title: 'Centrala sygnalizuje niski akumulator',
                place: 'Jan Kowalski · ul. Polna 3, Skawina',
                description: 'Centrala co kilka minut sygnalizuje niski poziom akumulatora.',
                createdAt: new \DateTimeImmutable('2026-10-31 09:30'),
                status: TicketStatus::New,
            ),
            new Ticket(
                id: 1039,
                clientName: 'Sklep „Pod Dębem”',
                category: 'Fałszywe alarmy',
                title: 'Fałszywe alarmy w nocy',
                place: 'Sklep „Pod Dębem” · Rynek 4, Wieliczka',
                description: 'W nocy kilkukrotnie włączał się alarm bez przyczyny.',
                createdAt: new \DateTimeImmutable('2026-10-28 07:50'),
                status: TicketStatus::Done,
                technician: 'Piotr Wiśniewski',
            ),
            new Ticket(
                id: 1038,
                clientName: 'Maria Wójcik',
                category: 'Inne',
                title: 'Pytanie o rozbudowę instalacji',
                place: 'Maria Wójcik · Myślenice',
                description: 'Klientka pyta o dodanie czujnika w garażu.',
                createdAt: new \DateTimeImmutable('2026-10-27 16:44'),
                status: TicketStatus::Done,
                technician: 'Tomasz Lis',
            ),
        ];
    }

    public function findAll(): array
    {
        return $this->tickets;
    }

    public function find(int $id): ?Ticket
    {
        foreach ($this->tickets as $ticket) {
            if ($ticket->getId() === $id) {
                return $ticket;
            }
        }

        return null;
    }

    public function findByTechnician(string $technician): array
    {
        $assigned = array_filter(
            $this->tickets,
            static fn (Ticket $ticket): bool => $ticket->getTechnician() === $technician
                && $ticket->getVisitTime() !== null,
        );

        usort(
            $assigned,
            static fn (Ticket $a, Ticket $b): int => $a->getVisitTime() <=> $b->getVisitTime(),
        );

        return $assigned;
    }
}
