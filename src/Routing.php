<?php

declare(strict_types=1);

namespace App;

use App\Controller\AppController;
use App\Model\UserRole;
use App\Service\AccessControl;
use App\Service\ForbiddenException;

final class Routing
{
    private array $routes = [];

    public function __construct(private readonly Container $container)
    {
    }

    /** @param list<UserRole>|null $roles Dozwolone role; null oznacza trasę publiczną. */
    public function get(string $path, string $controller, string $action, ?array $roles = null): void
    {
        $this->add('GET', $path, $controller, $action, $roles);
    }

    /** @param list<UserRole>|null $roles Dozwolone role; null oznacza trasę publiczną. */
    public function post(string $path, string $controller, string $action, ?array $roles = null): void
    {
        $this->add('POST', $path, $controller, $action, $roles);
    }

    private function add(
        string $method,
        string $path,
        string $controller,
        string $action,
        ?array $roles,
    ): void {
        $this->routes[] = [
            'method' => $method,
            'pattern' => $this->createPattern($path),
            'controller' => $controller,
            'action' => $action,
            'roles' => $roles,
        ];
    }

	/* 
	Funkcja dzieli ścieżkę na fragmenty. Zwykłe fragmenty pozostawia bez zmian, 
	a fragment zapisany w klamrach, na przykład {id}, zamienia na nazwany 
	parametr przyjmujący cyfry. Następnie ponownie składa ścieżkę w wyrażenie regularne.
	*/
    private function createPattern(string $path): string
    {
        $parts = explode('/', $path);

        foreach ($parts as &$part) {
            if (str_starts_with($part, '{') && str_ends_with($part, '}')) {
                $parameterName = trim($part, '{}');
                $part = '(?P<' . $parameterName . '>\d+)';
                continue;
            }

            $part = preg_quote($part, '~');
        }
        unset($part);

        return '~^' . implode('/', $parts) . '$~';
    }

    public function dispatch(string $method, string $uri): bool
    {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            if (!preg_match($route['pattern'], $path, $matches)) {
                continue;
            }

            $parameters = array_filter(
                $matches,
                static fn (int|string $key): bool => is_string($key),
                ARRAY_FILTER_USE_KEY,
            );

            $parameters = array_map(
                static fn (string $value): int|string =>
                    ctype_digit($value) ? (int) $value : $value,
                $parameters,
            );

            $this->container->get(AccessControl::class)->check($route['roles']);

            if ($method === 'POST') {
                $this->assertValidCsrfToken();
            }

            $controllerClass = $route['controller'];
            $controller = $this->container->get($controllerClass);

            if (!$controller instanceof AppController) {
                throw new \RuntimeException('Invalid controller');
            }

            $controller->{$route['action']}(...$parameters);

            return true;
        }

        return false;
    }

    /** Każde żądanie POST musi zawierać token CSRF z bieżącej sesji. */
    private function assertValidCsrfToken(): void
    {
        $token = $this->container->get(Request::class)->post('csrfToken') ?? '';

        if (!$this->container->get(Session::class)->isCsrfTokenValid($token)) {
            throw new ForbiddenException('Invalid CSRF token.');
        }
    }
}
