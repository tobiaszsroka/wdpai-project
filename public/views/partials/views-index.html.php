<?php
$groups = [
    'Widoki web' => [
        '/login' => 'Logowanie i rejestracja',
        '/dashboard' => 'Panel główny',
        '/clients' => 'Klienci i instalacje',
        '/tickets' => 'Zgłoszenia serwisowe',
        '/protocols' => 'Protokół prac',
    ],
    'Widoki mobilne' => [
        '/m/login' => 'Logowanie',
        '/m/tasks' => 'Moje zadania',
        '/m/tasks/1042' => 'Szczegóły zgłoszenia',
        '/m/report' => 'Zgłoś usterkę',
        '/m/installation' => 'Karta instalacji',
    ],
    'Pozostałe' => [
        '/installations' => 'Lista instalacji',
        '/installations/1' => 'Szczegóły instalacji',
        '/projects' => 'Lista projektów',
        '/projects/12' => 'Szczegóły projektu',
    ],
];
?>
<section class="views-index" aria-labelledby="views-index-title">
    <h2 id="views-index-title">Wszystkie widoki</h2>
    <div class="views-index-grid">
        <?php foreach ($groups as $title => $links): ?>
            <nav aria-label="<?= htmlspecialchars($title) ?>">
                <h3><?= htmlspecialchars($title) ?></h3>
                <ul>
                    <?php foreach ($links as $href => $label): ?>
                        <li><a href="<?= htmlspecialchars($href) ?>"><?= htmlspecialchars($label) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        <?php endforeach; ?>
    </div>
</section>
