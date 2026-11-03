<?php
$items = [
    'dashboard' => ['/dashboard', 'Panel główny'],
    'clients' => ['/clients', 'Klienci i instalacje'],
    'tickets' => ['/tickets', 'Zgłoszenia serwisowe'],
    'protocols' => ['/protocols', 'Protokoły prac'],
];
?>
<aside class="sidebar">
    <div class="logo"><span class="logo-mark" aria-hidden="true">✓</span> SerwisBook</div>
    <nav aria-label="Menu główne">
        <?php foreach ($items as $key => [$href, $label]): ?>
            <a href="<?= $href ?>"<?= $key === $active ? ' aria-current="page"' : '' ?>><?= $label ?></a>
        <?php endforeach; ?>
    </nav>
    <div class="user">
        <strong><?= htmlspecialchars($userName) ?></strong>
        <span><?= htmlspecialchars($userRole) ?></span>
        <button type="button" class="theme-toggle" data-theme-toggle>Motyw jasny / ciemny</button>
        <a href="/login">Wyloguj</a>
    </div>
</aside>
