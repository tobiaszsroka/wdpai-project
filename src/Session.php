<?php

declare(strict_types=1);

namespace App;

use App\Model\User;
use App\Model\UserRole;

/**
 * Jedyne miejsce, które zna $_SESSION: start, logowanie, wylogowanie i token CSRF.
 * W sesji trzymamy tylko identyfikator, imię i rolę, nigdy hasło ani hash.
 */
final class Session
{
    public function start(): void
    {
        if (session_status() !== PHP_SESSION_NONE) {
            return;
        }

        $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https';

        ini_set('session.use_strict_mode', '1');
        ini_set('session.use_only_cookies', '1');
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'secure' => $isHttps,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        session_start();
    }

    public function login(User $user): void
    {
        // Nowy identyfikator po zmianie poziomu zaufania chroni przed session fixation.
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user_name'] = $user->getName();
        $_SESSION['user_role'] = $user->getRole()->value;
        $_SESSION['client_id'] = $user->getClientId();
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', [
                'expires' => time() - 42000,
                'path' => $params['path'],
                'domain' => $params['domain'],
                'secure' => $params['secure'],
                'httponly' => $params['httponly'],
                'samesite' => $params['samesite'] ?: 'Lax',
            ]);
        }

        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }

    public function isLoggedIn(): bool
    {
        return $this->userId() !== null && $this->role() !== null;
    }

    public function userId(): ?int
    {
        return isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
    }

    public function clientId(): ?int
    {
        return isset($_SESSION['client_id']) ? (int) $_SESSION['client_id'] : null;
    }

    public function userName(): ?string
    {
        return isset($_SESSION['user_name']) ? (string) $_SESSION['user_name'] : null;
    }

    public function role(): ?UserRole
    {
        return UserRole::tryFrom((string) ($_SESSION['user_role'] ?? ''));
    }

    public function csrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return (string) $_SESSION['csrf_token'];
    }

    public function isCsrfTokenValid(string $token): bool
    {
        return isset($_SESSION['csrf_token']) && hash_equals((string) $_SESSION['csrf_token'], $token);
    }
}
