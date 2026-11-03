<?php require __DIR__ . '/partials/head.html.php'; ?>
<div class="app">
    <?php require __DIR__ . '/partials/sidebar.html.php'; ?>
    <main class="content">
        <header class="page-head">
            <h1>Protokół wykonania prac</h1>
            <button type="button" class="btn" onclick="window.print()">Drukuj / zapisz jako PDF</button>
        </header>
        <div class="split">
            <form class="card" method="post" action="/protocols" style="flex:1 1 300px" aria-label="Dane protokołu">
                <div class="field"><label for="client">Klient</label>
                    <select id="client" name="client"><option>Anna Nowak, ul. Lipowa 12</option><option>Jan Kowalski, ul. Polna 3</option></select></div>
                <div class="field"><label for="type">Rodzaj instalacji (szablon)</label>
                    <select id="type" name="type"><option>Monitoring wizyjny</option><option>System alarmowy</option><option>Sieć komputerowa</option></select></div>
                <div class="field"><label for="date">Data wykonania</label>
                    <input id="date" name="date" type="text" value="<?= htmlspecialchars($protocol['date']) ?>"></div>
                <div class="field"><label for="devices">Zamontowane urządzenia</label>
                    <textarea id="devices" name="devices" rows="3"><?= htmlspecialchars(implode("\n", array_map(fn ($d) => $d[0] . ', ' . $d[1], $protocol['devices']))) ?></textarea></div>
                <div class="field"><label for="description">Opis wykonanych prac</label>
                    <textarea id="description" name="description" rows="4"><?= htmlspecialchars($protocol['description']) ?></textarea></div>
                <button type="submit" class="btn btn-block">Zapisz protokół</button>
            </form>
            <section class="paper" aria-label="Podgląd protokołu">
                <header>
                    <div><strong class="note" style="letter-spacing:1px;text-transform:uppercase">Firma instalacyjna</strong><p>ul. Przykładowa 1, 30-000 Kraków</p></div>
                    <p style="text-align:right;font-size:14px">Nr: <strong><?= htmlspecialchars($protocol['number']) ?></strong><br>Data: <?= htmlspecialchars($protocol['date']) ?></p>
                </header>
                <h2>Protokół wykonania prac – <?= htmlspecialchars(mb_strtolower($protocol['type'])) ?></h2>
                <div class="two">
                    <div><strong>Klient</strong><br><?= htmlspecialchars($protocol['client']) ?><br><?= htmlspecialchars($protocol['address']) ?></div>
                    <div><strong>Wykonawca</strong><br><?= htmlspecialchars($protocol['technician']) ?></div>
                </div>
                <table>
                    <thead><tr><th scope="col">Lp.</th><th scope="col">Urządzenie</th><th scope="col">Ilość</th></tr></thead>
                    <tbody>
                        <?php foreach ($protocol['devices'] as $i => [$name, $qty]): ?>
                            <tr><td><?= $i + 1 ?></td><td><?= htmlspecialchars($name) ?></td><td><?= htmlspecialchars($qty) ?></td></tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div><strong>Zakres wykonanych prac</strong><p><?= htmlspecialchars($protocol['description']) ?></p></div>
                <div class="signatures"><div>Podpis wykonawcy</div><div>Podpis klienta</div></div>
            </section>
        </div>
    </main>
</div>
<?php require __DIR__ . '/partials/foot.html.php'; ?>
