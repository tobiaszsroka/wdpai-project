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
use App\Routing;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$routing = new Routing();

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


$routeFound = $routing->dispatch(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI'],
);

if (!$routeFound) {
    (new DefaultController())->notFound();
}