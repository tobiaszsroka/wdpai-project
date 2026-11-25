<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\ReportTicketData;
use App\Model\TicketStatus;
use App\Repository\InstallationRepositoryInterface;
use App\Repository\TicketRepositoryInterface;
use App\Model\Ticket;
use App\Model\UserRole;
use App\Request;
use App\Service\ForbiddenException;
use App\Service\TicketService;
use App\Service\ValidationException;
use App\Session;

final class TicketController extends AppController
{
    public function __construct(
        Session $session,
        private readonly TicketRepositoryInterface $tickets,
        private readonly InstallationRepositoryInterface $installations,
        private readonly TicketService $ticketService,
        private readonly Request $request,
    ) {
        parent::__construct($session);
    }

    public function index(): void
    {
        $rawStatus = $this->request->query('status');
        $status = ($rawStatus === null || $rawStatus === '') ? null : TicketStatus::tryFrom($rawStatus);

        if ($rawStatus !== null && $rawStatus !== '' && $status === null) {
            $this->renderBadRequest();

            return;
        }

        $this->render('tickets', [
            'pageTitle' => 'Zgłoszenia serwisowe',
            'active' => 'tickets',
            'userName' => 'Marta Zielińska',
            'userRole' => 'Administrator',
            'technicians' => ['Piotr Wiśniewski', 'Tomasz Lis'],
            'statuses' => TicketStatus::cases(),
            'selectedStatus' => $status,
            'tickets' => $this->tickets->findAll($status),
        ]);
    }

    public function mobileIndex(): void
    {
        $this->render('mobile/tasks', [
            'pageTitle' => 'Moje zadania',
            'today' => 'Poniedziałek, 2 listopada',
            'technician' => (string) $this->session->userName(),
            'tasks' => $this->tickets->findByTechnician((string) $this->session->userName()),
        ]);
    }

    public function mobileShow(int $id): void
    {
        $ticket = $this->tickets->find($id);

        if ($ticket === null) {
            $this->renderNotFound();

            return;
        }

        $this->assertCanHandle($ticket);

        $this->render('mobile/ticket', [
            'pageTitle' => 'Zgłoszenie #' . $id,
            'ticket' => $ticket,
            'statuses' => TicketStatus::selectableByTechnician(),
        ]);
    }

    public function mobileUpdateStatus(int $id): void
    {
        $ticket = $this->tickets->find($id);

        if ($ticket === null) {
            $this->renderNotFound();

            return;
        }

        $this->assertCanHandle($ticket);

        $status = TicketStatus::tryFrom((string) $this->request->post('status'));

        if ($status === null || !in_array($status, TicketStatus::selectableByTechnician(), true)) {
            $this->renderBadRequest();

            return;
        }

        $this->tickets->updateStatus($id, $status);
        $this->redirect('/m/tasks/' . $id);
    }

    public function mobileReport(): void
    {
        $created = $this->request->query('created');

        $this->renderReportForm(
            createdId: ($created !== null && ctype_digit($created)) ? (int) $created : null,
        );
    }

    public function mobileReportSubmit(): void
    {
        $installationId = $this->request->post('installation');
        $data = new ReportTicketData(
            ($installationId !== null && ctype_digit($installationId)) ? (int) $installationId : 0,
            (string) $this->request->post('category'),
            (string) $this->request->post('description'),
        );

        try {
            $ticket = $this->ticketService->report($data, (int) $this->session->clientId());
        } catch (ValidationException $exception) {
            http_response_code(422);
            $this->renderReportForm(errors: $exception->getErrors(), data: $data);

            return;
        }

        $this->redirect('/m/report?created=' . $ticket->getId());
    }

    /**
     * @param array<string, string> $errors
     */
    private function renderReportForm(?int $createdId = null, array $errors = [], ?ReportTicketData $data = null): void
    {
        $options = [];
        foreach ($this->installations->findByClientId((int) $this->session->clientId()) as $installation) {
            $options[$installation->getId()] = $installation->getClientName() . ' – ' . $installation->getTitle();
        }

        $this->render('mobile/report', [
            'pageTitle' => 'Zgłoś usterkę',
            'installations' => $options,
            'categories' => TicketService::CATEGORIES,
            'errors' => $errors,
            'data' => $data,
            'createdId' => $createdId,
        ]);
    }

    /** Technik obsługuje tylko zgłoszenia przypisane do siebie, administrator wszystkie. */
    private function assertCanHandle(Ticket $ticket): void
    {
        if ($this->session->role() === UserRole::Technician
            && $ticket->getTechnician() !== $this->session->userName()) {
            throw new ForbiddenException('Ticket assigned to another technician.');
        }
    }
}
