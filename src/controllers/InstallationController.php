<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Installation;
use App\Model\UserRole;
use App\Repository\InstallationRepositoryInterface;
use App\Request;
use App\Service\ForbiddenException;
use App\Session;

final class InstallationController extends AppController
{
    private const DEFAULT_CARD_INSTALLATION_ID = 1;

    public function __construct(
        Session $session,
        private readonly InstallationRepositoryInterface $installations,
        private readonly Request $request,
    ) {
        parent::__construct($session);
    }

    public function index(): void
    {
        $this->render('installations', [
            'pageTitle' => 'Instalacje',
            'installations' => $this->visibleInstallations(),
        ]);
    }

    public function show(int $id): void
    {
        $installation = $this->installations->find($id);

        if ($installation === null) {
            $this->renderNotFound();

            return;
        }

        $this->assertCanView($installation);

        $this->render('installation', [
            'pageTitle' => 'Instalacja: ' . $installation->getClientName(),
            'installation' => $installation,
        ]);
    }

    public function mobileCard(): void
    {
        $installation = $this->cardInstallation();

        if ($installation === null) {
            $this->renderNotFound();

            return;
        }

        $this->assertCanView($installation);

        $this->render('mobile/installation', [
            'pageTitle' => 'Karta instalacji',
            'installation' => $installation,
            'daysLeft' => $installation->daysUntilInspection(new \DateTimeImmutable('today')),
        ]);
    }

    /** Klient widzi tylko swoje instalacje, technik i administrator wszystkie. */
    private function visibleInstallations(): array
    {
        return $this->session->role() === UserRole::Client
            ? $this->installations->findByClientId((int) $this->session->clientId())
            : $this->installations->findAll();
    }

    private function assertCanView(Installation $installation): void
    {
        if ($this->session->role() === UserRole::Client
            && $installation->getClientId() !== $this->session->clientId()) {
            throw new ForbiddenException('Installation belongs to another client.');
        }
    }

    /** Karta wskazana parametrem ?id=, a bez niego pierwsza dostępna dla użytkownika. */
    private function cardInstallation(): ?Installation
    {
        $id = $this->request->query('id');

        if ($id !== null && ctype_digit($id)) {
            return $this->installations->find((int) $id);
        }

        if ($this->session->role() === UserRole::Client) {
            return $this->installations->findByClientId((int) $this->session->clientId())[0] ?? null;
        }

        return $this->installations->find(self::DEFAULT_CARD_INSTALLATION_ID);
    }
}
