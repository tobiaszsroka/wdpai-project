<?php

declare(strict_types=1);

namespace App\Controller;

use App\Session;

abstract class AppController
{
    public function __construct(protected readonly Session $session)
    {
    }

    protected function render(string $template, array $variables = []): void
    {
        $templatePath = dirname(__DIR__, 2) . '/public/views/' . $template . '.html.php';

        if (!is_file($templatePath)) {
            throw new \RuntimeException('View not found: ' . $template);
        }

        $variables += [
            'csrfToken' => $this->session->csrfToken(),
            'currentUser' => $this->session->isLoggedIn()
                ? ['name' => (string) $this->session->userName(), 'role' => $this->session->role()]
                : null,
        ];

        extract($variables, EXTR_SKIP);
        require $templatePath;
    }

    protected function renderNotFound(): void
    {
        http_response_code(404);
        $this->render('not-found', [
            'pageTitle' => 'Nie znaleziono strony',
        ]);
    }

    protected function renderForbidden(): void
    {
        http_response_code(403);
        $this->render('forbidden', [
            'pageTitle' => 'Brak dostępu',
        ]);
    }

    protected function renderBadRequest(): void
    {
        http_response_code(400);
        $this->render('bad-request', [
            'pageTitle' => 'Nieprawidłowe żądanie',
        ]);
    }

    /** Przekierowanie po udanym POST (wzorzec Post/Redirect/Get). */
    protected function redirect(string $path): void
    {
        header('Location: ' . $path, true, 303);
    }
}
