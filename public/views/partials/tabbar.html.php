<?php
use App\Model\UserRole;

$items = $currentUser['role'] === UserRole::Client
    ? ['report' => ['/m/report', 'Zgłoszenie'], 'installation' => ['/m/installation', 'Instalacje']]
    : ['tasks' => ['/m/tasks', 'Zadania'], 'installation' => ['/m/installation', 'Instalacje']];
?>
<nav class="tabbar" aria-label="Nawigacja główna">
    <?php foreach ($items as $key => [$href, $label]): ?>
        <a href="<?= $href ?>"<?= $key === ($active ?? '') ? ' aria-current="page"' : '' ?>><?= $label ?></a>
    <?php endforeach; ?>
    <form method="post" action="/logout">
        <?php require __DIR__ . '/csrf-field.html.php'; ?>
        <input type="hidden" name="area" value="mobile">
        <button type="submit">Wyloguj</button>
    </form>
</nav>
