<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\InMemoryInstallationRepository;
use App\Repository\InstallationRepositoryInterface;

final class InstallationController extends AppController
{
    private const DEMO_INSTALLATION_ID = 1;

    public function __construct(
        private readonly InstallationRepositoryInterface $installations = new InMemoryInstallationRepository(),
    ) {
    }

    public function index(): void
    {
        $this->render('installations', [
            'pageTitle' => 'Instalacje',
            'installations' => $this->installations->findAll(),
        ]);
    }

    public function show(int $id): void
    {
        $installation = $this->installations->find($id);

        if ($installation === null) {
            $this->renderNotFound();

            return;
        }

        $this->render('installation', [
            'pageTitle' => 'Instalacja: ' . $installation->getClientName(),
            'installation' => $installation,
        ]);
    }

    public function mobileCard(): void
    {
        $installation = $this->installations->find(self::DEMO_INSTALLATION_ID);

        if ($installation === null) {
            $this->renderNotFound();

            return;
        }

        $this->render('mobile/installation', [
            'pageTitle' => 'Karta instalacji',
            'installation' => $installation,
            'daysLeft' => $installation->daysUntilInspection(new \DateTimeImmutable('today')),
        ]);
    }
}
