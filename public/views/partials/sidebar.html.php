<?php
use App\Model\UserRole;

$items = [
    'dashboard' => ['/dashboard', 'Panel główny', [UserRole::Admin]],
    'clients' => ['/clients', 'Klienci i instalacje', [UserRole::Admin]],
    'tickets' => ['/tickets', 'Zgłoszenia serwisowe', [UserRole::Admin]],
    'protocols' => ['/protocols', 'Protokoły prac', [UserRole::Admin, UserRole::Technician]],
];
?>
<aside class="sidebar">
    <div class="logo"><span class="logo-mark" aria-hidden="true">✓</span> SerwisBook</div>
    <nav aria-label="Menu główne">
        <?php foreach ($items as $key => [$href, $label, $roles]): ?>
            <?php if (in_array($currentUser['role'], $roles, true)): ?>
                <a href="<?= $href ?>"<?= $key === $active ? ' aria-current="page"' : '' ?>><?= $label ?></a>
            <?php endif; ?>
        <?php endforeach; ?>
    </nav>
    <div class="user">
        <strong><?= htmlspecialchars($currentUser['name']) ?></strong>
        <span><?= htmlspecialchars($currentUser['role']->label()) ?></span>
        <form method="post" action="/logout">
            <?php require __DIR__ . '/csrf-field.html.php'; ?>
            <button type="submit" class="link-button">Wyloguj</button>
        </form>
    </div>
</aside>
