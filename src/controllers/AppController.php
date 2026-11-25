<?php

declare(strict_types=1);

namespace App\Controller;

abstract class AppController
{
    protected function render(string $template, array $variables = []): void
    {
        $templatePath = dirname(__DIR__, 2) . '/public/views/' . $template . '.html.php';

        if (!is_file($templatePath)) {
            throw new \RuntimeException('View not found: ' . $template);
        }

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
