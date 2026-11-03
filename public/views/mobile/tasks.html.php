<?php $active = 'tasks'; require __DIR__ . '/../partials/head.html.php'; ?>
<div class="phone">
    <header class="phone-head">
        <p><?= htmlspecialchars($today) ?></p>
        <h1>Moje zadania</h1>
        <p>Technik: <?= htmlspecialchars($technician) ?> · <?= count($tasks) ?> zadania</p>
    </header>
    <main class="phone-body">
        <?php foreach ($tasks as $t): ?>
            <a class="card task" href="/m/tasks/<?= (int) $t['id'] ?>">
                <span class="row"><time><?= htmlspecialchars($t['time']) ?></time><span class="chip chip-<?= htmlspecialchars($t['tone']) ?>"><?= htmlspecialchars($t['status']) ?></span></span>
                <strong><?= htmlspecialchars($t['title']) ?></strong>
                <span class="muted"><?= htmlspecialchars($t['place']) ?></span>
            </a>
        <?php endforeach; ?>
    </main>
    <?php require __DIR__ . '/../partials/tabbar.html.php'; ?>
</div>
<?php require __DIR__ . '/../partials/foot.html.php'; ?>
