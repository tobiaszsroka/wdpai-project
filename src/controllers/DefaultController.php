<?php

declare(strict_types=1);

require_once __DIR__ . '/AppController.php';

class DefaultController extends AppController
{
    public function home(): void
    {
        $this->render('home', [
            'pageTitle' => 'Strona Główna'
        ]);
    }
}