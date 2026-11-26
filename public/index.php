<?php

declare(strict_types=1);

use App\Controller\ClientController;
use App\Controller\DashboardController;
use App\Controller\DefaultController;
use App\Controller\InstallationController;
use App\Controller\ProjectController;
use App\Controller\ProtocolController;
use App\Controller\SecurityController;
use App\Controller\TicketController;
use App\Container;
use App\Database;
use App\Repository\InstallationRepositoryInterface;
use App\Repository\PdoInstallationRepository;
use App\Repository\PdoTicketRepository;
use App\Repository\PdoUserRepository;
use App\Repository\TicketRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Request;
use App\Session;
use App\Model\UserRole;
use App\Routing;
use App\Service\ForbiddenException;
use App\Service\UnauthenticatedException;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$container = new Container();
$container->bind(Request::class, static fn (): Request => Request::fromGlobals());
$container->bind(PDO::class, static fn (): PDO => Database::fromEnvironment()->connect());
$container->bind(
    TicketRepositoryInterface::class,
    static fn (Container $c): PdoTicketRepository => new PdoTicketRepository($c->get(PDO::class)),
);
$container->bind(
    InstallationRepositoryInterface::class,
    static fn (Container $c): PdoInstallationRepository => new PdoInstallationRepository($c->get(PDO::class)),
);

$container->bind(
    UserRepositoryInterface::class,
    static fn (Container $c): PdoUserRepository => new PdoUserRepository($c->get(PDO::class)),
);

$container->get(Session::class)->start();

$routing = new Routing($container);

// Macierz uprawnień: czwarty argument (role) to biała lista, brak argumentu oznacza trasę publiczną.
$anyUser = UserRole::cases();
$staff = [UserRole::Admin, UserRole::Technician];
$admin = [UserRole::Admin];
$technician = [UserRole::Technician];
$client = [UserRole::Client];

$routing->get('/projects', ProjectController::class, 'index');
$routing->get('/projects/{id}', ProjectController::class, 'show');
$routing->get('/', DefaultController::class, 'index');

$routing->get('/installations', InstallationController::class, 'index', $anyUser);
$routing->get('/installations/{id}', InstallationController::class, 'show', $anyUser);

$routing->get('/login', SecurityController::class, 'login');
$routing->post('/login', SecurityController::class, 'login');
$routing->get('/register', SecurityController::class, 'register');
$routing->post('/register', SecurityController::class, 'register');
$routing->post('/logout', SecurityController::class, 'logout', $anyUser);

$routing->get('/dashboard', DashboardController::class, 'index', $admin);
$routing->get('/clients', ClientController::class, 'index', $admin);
$routing->get('/tickets', TicketController::class, 'index', $admin);
$routing->get('/protocols', ProtocolController::class, 'index', $staff);

$routing->get('/m/login', SecurityController::class, 'mobileLogin');
$routing->post('/m/login', SecurityController::class, 'mobileLogin');
$routing->get('/m/tasks', TicketController::class, 'mobileIndex', $technician);
$routing->get('/m/tasks/{id}', TicketController::class, 'mobileShow', $staff);
$routing->post('/m/tasks/{id}', TicketController::class, 'mobileUpdateStatus', $staff);
$routing->get('/m/report', TicketController::class, 'mobileReport', $client);
$routing->post('/m/report', TicketController::class, 'mobileReportSubmit', $client);
$routing->get('/m/installation', InstallationController::class, 'mobileCard', $anyUser);

$wantsJson = str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');
$defaultController = $container->get(DefaultController::class);

try {
    $routeFound = $routing->dispatch(
        $_SERVER['REQUEST_METHOD'],
        $_SERVER['REQUEST_URI'],
    );
} catch (UnauthenticatedException) {
    if ($wantsJson) {
        http_response_code(401);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Unauthorized']);

        return;
    }

    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
    header('Location: ' . (str_starts_with($path, '/m/') ? '/m/login' : '/login'), true, 303);

    return;
} catch (ForbiddenException) {
    if ($wantsJson) {
        http_response_code(403);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Forbidden']);

        return;
    }

    $defaultController->forbidden();

    return;
} catch (Throwable $exception) {
    error_log((string) $exception);
    $defaultController->serverError();

    return;
}

if (!$routeFound) {
    $defaultController->notFound();
}
