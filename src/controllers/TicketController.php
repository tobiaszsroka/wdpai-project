<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\InMemoryTicketRepository;
use App\Repository\TicketRepositoryInterface;

final class TicketController extends AppController
{
    private const DEMO_TECHNICIAN = 'Piotr Wiśniewski';

    public function __construct(
        private readonly TicketRepositoryInterface $tickets = new InMemoryTicketRepository(),
    ) {
    }

    public function index(): void
    {
        $this->render('tickets', [
            'pageTitle' => 'Zgłoszenia serwisowe',
            'active' => 'tickets',
            'userName' => 'Marta Zielińska',
            'userRole' => 'Administrator',
            'technicians' => ['Piotr Wiśniewski', 'Tomasz Lis'],
            'tickets' => $this->tickets->findAll(),
        ]);
    }

    public function mobileIndex(): void
    {
        $this->render('mobile/tasks', [
            'pageTitle' => 'Moje zadania',
            'today' => 'Poniedziałek, 2 listopada',
            'technician' => self::DEMO_TECHNICIAN,
            'tasks' => $this->tickets->findByTechnician(self::DEMO_TECHNICIAN),
        ]);
    }

    public function mobileShow(int $id): void
    {
        $ticket = $this->tickets->find($id);

        if ($ticket === null) {
            $this->renderNotFound();

            return;
        }

        $this->render('mobile/ticket', [
            'pageTitle' => 'Zgłoszenie #' . $id,
            'ticket' => $ticket,
        ]);
    }

    public function mobileReport(): void
    {
        $this->render('mobile/report', [
            'pageTitle' => 'Zgłoś usterkę',
            'installations' => ['Dom, ul. Lipowa 12 – monitoring i alarm', 'Garaż, ul. Polna 3 – alarm'],
            'categories' => ['Kamera nie działa', 'Alarm zgłasza błąd', 'Brak połączenia z siecią', 'Inne'],
        ]);
    }
}
