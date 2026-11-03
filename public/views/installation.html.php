<?php require __DIR__ . '/partials/head.html.php'; ?>
<?php require __DIR__ . '/partials/site-nav.html.php'; ?>
<main class="page">
    <article class="card">
        <h1>Instalacja nr <?= (int) $installationId ?></h1>
        <dl class="details">
            <dt>Klient</dt>
            <dd><?= htmlspecialchars($installation['client']) ?></dd>
            <dt>Adres</dt>
            <dd><?= htmlspecialchars($installation['address']) ?></dd>
            <dt>Rodzaj instalacji</dt>
            <dd><?= htmlspecialchars($installation['type']) ?></dd>
            <dt>Następny przegląd</dt>
            <dd>
                <time datetime="<?= htmlspecialchars($installation['nextInspection']) ?>">
                    <?= htmlspecialchars($installation['nextInspection']) ?>
                </time>
            </dd>
        </dl>
        <p><a href="/installations">Wróć do listy instalacji</a></p>
    </article>
</main>
<footer class="page site-footer">
    <p>SerwisBook – książka serwisowa instalacji alarmowych i monitoringu.</p>
</footer>
<?php require __DIR__ . '/partials/foot.html.php'; ?>
