<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\RegisterData;
use App\Request;
use App\Service\AuthService;
use App\Service\ValidationException;
use App\Session;

final class SecurityController extends AppController
{
    private const AREA_MOBILE = 'mobile';

    public function __construct(
        Session $session,
        private readonly AuthService $auth,
        private readonly Request $request,
    ) {
        parent::__construct($session);
    }

    public function login(): void
    {
        $this->handleLogin('login');
    }

    public function mobileLogin(): void
    {
        $this->handleLogin('mobile/login');
    }

    public function register(): void
    {
        if ($this->redirectIfLoggedIn()) {
            return;
        }

        if ($this->request->getMethod() !== 'POST') {
            $this->renderRegisterForm();

            return;
        }

        $data = new RegisterData(
            (string) $this->request->post('name'),
            (string) $this->request->post('email'),
            (string) $this->request->post('password'),
            (string) $this->request->post('passwordConfirmation'),
        );

        try {
            $this->auth->registerClient($data);
        } catch (ValidationException $exception) {
            http_response_code(422);
            // Hasła nie wracają do formularza, tylko imię i e-mail.
            $this->renderRegisterForm($exception->getErrors(), $data);

            return;
        }

        $this->redirect('/login?registered=1');
    }

    public function logout(): void
    {
        $area = $this->request->post('area');
        $this->session->logout();
        $this->redirect($area === self::AREA_MOBILE ? '/m/login' : '/login');
    }

    private function handleLogin(string $view): void
    {
        if ($this->redirectIfLoggedIn()) {
            return;
        }

        if ($this->request->getMethod() !== 'POST') {
            $this->render($view, [
                'pageTitle' => 'Logowanie',
                'registered' => $this->request->query('registered') === '1',
                'errors' => [],
                'email' => '',
            ]);

            return;
        }

        $email = (string) $this->request->post('email');
        $user = $this->auth->authenticate($email, (string) $this->request->post('password'));

        if ($user === null) {
            http_response_code(401);
            $this->render($view, [
                'pageTitle' => 'Logowanie',
                'registered' => false,
                'errors' => ['Nieprawidłowy e-mail lub hasło.'],
                'email' => $email,
            ]);

            return;
        }

        $this->session->login($user);
        $this->redirect($user->getRole()->homePath());
    }

    private function redirectIfLoggedIn(): bool
    {
        $role = $this->session->role();

        if ($role === null) {
            return false;
        }

        $this->redirect($role->homePath());

        return true;
    }

    /** @param array<string, string> $errors */
    private function renderRegisterForm(array $errors = [], ?RegisterData $data = null): void
    {
        $this->render('register', [
            'pageTitle' => 'Rejestracja',
            'errors' => $errors,
            'name' => $data?->name ?? '',
            'email' => $data?->email ?? '',
        ]);
    }
}
