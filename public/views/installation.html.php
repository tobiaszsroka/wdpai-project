<?php require __DIR__ . '/partials/head.html.php'; ?>
<?php require __DIR__ . '/partials/site-nav.html.php'; ?>
<main class="page">
    <article class="card">
        <h1>Instalacja nr <?= $installation->getId() ?></h1>
        <dl class="details">
            <dt>Klient</dt>
            <dd><?= htmlspecialchars($installation->getClientName()) ?></dd>
            <dt>Adres</dt>
            <dd><?= htmlspecialchars($installation->getAddress()) ?></dd>
            <dt>Rodzaj instalacji</dt>
            <dd><?= htmlspecialchars($installation->getType()) ?></dd>
            <dt>Następny przegląd</dt>
            <dd>
                <time datetime="<?= htmlspecialchars($installation->getNextInspection()->format('Y-m-d')) ?>">
                    <?= htmlspecialchars($installation->getNextInspection()->format('d.m.Y')) ?>
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
