<?php require __DIR__ . '/partials/head.html.php'; ?>
<div class="app">
    <?php require __DIR__ . '/partials/sidebar.html.php'; ?>
    <main class="content">
        <header class="page-head">
            <div>
                <h1>Panel główny</h1>
                <p class="muted"><?= htmlspecialchars($today) ?></p>
            </div>
            <a class="btn" href="/tickets">+ Nowe zgłoszenie</a>
        </header>
        <section class="kpis" aria-label="Podsumowanie">
            <?php foreach ($stats as $label => $value): ?>
                <div class="card"><span class="muted"><?= htmlspecialchars($label) ?></span><strong><?= (int) $value ?></strong></div>
            <?php endforeach; ?>
        </section>
        <div class="split">
            <section class="card" style="flex:2 1 420px">
                <h2>Najnowsze zgłoszenia</h2>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th scope="col">Nr</th><th scope="col">Klient</th><th scope="col">Problem</th><th scope="col">Status</th></tr></thead>
                        <tbody>
                            <?php foreach ($tickets as $t): ?>
                                <tr>
                                    <td>#<?= (int) $t['id'] ?></td>
                                    <td><?= htmlspecialchars($t['client']) ?></td>
                                    <td><?= htmlspecialchars($t['problem']) ?></td>
                                    <td><span class="chip chip-<?= htmlspecialchars($t['tone']) ?>"><?= htmlspecialchars($t['status']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
            <section class="card" style="flex:1 1 280px">
                <h2>Nadchodzące przeglądy</h2>
                <ul class="list">
                    <?php foreach ($inspections as $i): ?>
                        <li><span><?= htmlspecialchars($i['client']) ?></span><strong><?= htmlspecialchars($i['date']) ?></strong></li>
                    <?php endforeach; ?>
                </ul>
                <p class="note">Klienci dostają przypomnienie e-mail 14 dni przed terminem.</p>
            </section>
        </div>
    </main>
</div>
<?php require __DIR__ . '/partials/foot.html.php'; ?>
