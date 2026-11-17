<?php

declare(strict_types=1);

namespace App\Controller;


final class DefaultController extends AppController
{
    public function index(): void
    {
        $this->render('home', [
            'pageTitle' => 'SerwisBook',
        ]);
    }

    public function notFound(): void
    {
        $this->renderNotFound();
    }

    public function serverError(): void
    {
        http_response_code(500);
        $this->render('server-error', [
            'pageTitle' => 'Błąd serwera',
        ]);
    }
}
