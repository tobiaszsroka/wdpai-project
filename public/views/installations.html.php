<?php require __DIR__ . '/partials/head.html.php'; ?>
<?php require __DIR__ . '/partials/site-nav.html.php'; ?>
<main class="page">
    <h1>Instalacje</h1>
    <section class="card" aria-labelledby="installations-list">
        <h2 id="installations-list">Lista instalacji klientów</h2>
        <ul class="plain-list">
            <?php foreach ($installations as $id => $installation): ?>
                <li>
                    <a href="/installations/<?= (int) $id ?>"><?= htmlspecialchars($installation['client']) ?></a>
                    <span class="muted"> – <?= htmlspecialchars($installation['address']) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
</main>
<footer class="page site-footer">
    <p>SerwisBook – książka serwisowa instalacji alarmowych i monitoringu.</p>
</footer>
<?php require __DIR__ . '/partials/foot.html.php'; ?>
