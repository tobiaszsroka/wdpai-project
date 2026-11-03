<?php
$items = [
    'tasks' => ['/m/tasks', 'Zadania'],
    'installation' => ['/m/installation', 'Instalacje'],
    'account' => ['/m/login', 'Konto'],
];
?>
<nav class="tabbar" aria-label="Nawigacja główna">
    <?php foreach ($items as $key => [$href, $label]): ?>
        <a href="<?= $href ?>"<?= $key === $active ? ' aria-current="page"' : '' ?>><?= $label ?></a>
    <?php endforeach; ?>
</nav>
