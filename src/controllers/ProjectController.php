<?php

declare(strict_types=1);

require_once __DIR__ . '/AppController.php';

class ProjectController extends AppController
{
    public function show(int $id): void
    {
        $this->render('project', [
            'pageTitle' => 'Szczegóły projektu',
            'projectId' => $id,
        ]);
    }

    public function index(): void
    {
        $this->render('projects', [
            'pageTitle' => 'Lista projektów'
        ]);
    }
}