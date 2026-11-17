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
use App\Repository\TicketRepositoryInterface;
use App\Routing;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$container = new Container();
$container->bind(PDO::class, static fn (): PDO => Database::fromEnvironment()->connect());
$container->bind(
    TicketRepositoryInterface::class,
    static fn (Container $c): PdoTicketRepository => new PdoTicketRepository($c->get(PDO::class)),
);
$container->bind(
    InstallationRepositoryInterface::class,
    static fn (Container $c): PdoInstallationRepository => new PdoInstallationRepository($c->get(PDO::class)),
);

$routing = new Routing($container);

$routing->get('/projects', ProjectController::class, 'index');
$routing->get('/projects/{id}', ProjectController::class, 'show');
$routing->get('/installations', InstallationController::class, 'index');
$routing->get('/installations/{id}', InstallationController::class, 'show');
$routing->get('/', DefaultController::class, 'index');

$routing->get('/login', SecurityController::class, 'login');
$routing->get('/dashboard', DashboardController::class, 'index');
$routing->get('/clients', ClientController::class, 'index');
$routing->get('/tickets', TicketController::class, 'index');
$routing->get('/protocols', ProtocolController::class, 'index');

$routing->get('/m/login', SecurityController::class, 'mobileLogin');
$routing->get('/m/tasks', TicketController::class, 'mobileIndex');
$routing->get('/m/tasks/{id}', TicketController::class, 'mobileShow');
$routing->get('/m/report', TicketController::class, 'mobileReport');
$routing->get('/m/installation', InstallationController::class, 'mobileCard');


try {
    $routeFound = $routing->dispatch(
        $_SERVER['REQUEST_METHOD'],
        $_SERVER['REQUEST_URI'],
    );
} catch (Throwable $exception) {
    error_log((string) $exception);
    (new DefaultController())->serverError();

    return;
}

if (!$routeFound) {
    (new DefaultController())->notFound();
}
