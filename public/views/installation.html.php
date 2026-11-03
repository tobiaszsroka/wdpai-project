<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
</head>
<body>
    <header>
        <nav aria-label="Menu główne">
            <a href="/">Strona główna</a>
            <a href="/installations">Instalacje</a>
        </nav>
    </header>
    <main>
        <article>
            <h1>Instalacja nr <?= (int) $installationId ?></h1>
            <dl>
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
    <footer>
        <p>SerwisBook – książka serwisowa instalacji alarmowych i monitoringu.</p>
    </footer>
</body>
</html>
