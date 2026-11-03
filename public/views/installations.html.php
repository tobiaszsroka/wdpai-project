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
        <h1>Instalacje</h1>
        <section aria-labelledby="installations-list">
            <h2 id="installations-list">Lista instalacji klientów</h2>
            <ul>
                <?php foreach ($installations as $id => $installation): ?>
                    <li>
                        <a href="/installations/<?= (int) $id ?>">
                            <?= htmlspecialchars($installation['client']) ?>
                        </a>
                        – <?= htmlspecialchars($installation['address']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
    <footer>
        <p>SerwisBook – książka serwisowa instalacji alarmowych i monitoringu.</p>
    </footer>
</body>
</html>
