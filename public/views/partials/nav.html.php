<?php
$navItems = [
    'home' => ['/', 'Strona główna'],
    'installations' => ['/installations', 'Instalacje'],
    'projects' => ['/projects', 'Projekty'],
    'dashboard' => ['/dashboard', 'Panel główny'],
    'clients' => ['/clients', 'Klienci'],
    'tickets' => ['/tickets', 'Zgłoszenia'],
    'protocols' => ['/protocols', 'Protokoły'],
];

$navPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

$navActive = $active ?? match (true) {
    $navPath === '/' => 'home',
    str_starts_with($navPath, '/installations'), str_starts_with($navPath, '/m/installation') => 'installations',
    str_starts_with($navPath, '/projects') => 'projects',
    str_starts_with($navPath, '/dashboard') => 'dashboard',
    str_starts_with($navPath, '/clients') => 'clients',
    str_starts_with($navPath, '/tickets'), str_starts_with($navPath, '/m/tasks'), str_starts_with($navPath, '/m/report') => 'tickets',
    str_starts_with($navPath, '/protocols') => 'protocols',
    default => null,
};

$navActive = match ($navActive) {
    'installation' => 'installations',
    'tasks' => 'tickets',
    default => $navActive,
};
?>
<header class="site-header">
    <nav class="site-nav" aria-label="Nawigacja główna">
        <ul class="site-nav-list">
            <?php foreach ($navItems as $key => [$href, $label]): ?>
                <li>
                    <a href="<?= htmlspecialchars($href) ?>"<?= $key === $navActive ? ' aria-current="page"' : '' ?>><?= htmlspecialchars($label) ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</header>
