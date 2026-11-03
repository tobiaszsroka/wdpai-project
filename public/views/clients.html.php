<?php require __DIR__ . '/partials/head.html.php'; ?>
<div class="app">
    <?php require __DIR__ . '/partials/sidebar.html.php'; ?>
    <main class="content">
        <header class="page-head">
            <h1>Klienci i instalacje</h1>
            <form class="toolbar" role="search">
                <label for="search" class="visually-hidden">Szukaj klienta</label>
                <input id="search" type="search" placeholder="Szukaj klienta lub adresu">
                <a class="btn" href="#">+ Nowy klient</a>
            </form>
        </header>
        <div class="split">
            <section aria-label="Lista klientów" class="grow-1">
                <ul class="client-list">
                    <?php foreach ($clients as $i => $c): ?>
                        <li<?= $i === 0 ? ' aria-current="true"' : '' ?>>
                            <strong><?= htmlspecialchars($c['name']) ?></strong>
                            <span class="note"><?= htmlspecialchars($c['summary']) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
            <section aria-label="Karta klienta" class="grow-2">
                <article class="card card-head">
                    <div>
                        <h2><?= htmlspecialchars($client['name']) ?></h2>
                        <p class="muted"><?= htmlspecialchars($client['contact']) ?></p>
                        <p class="muted"><?= htmlspecialchars($client['address']) ?></p>
                    </div>
                    <div class="toolbar"><a class="btn btn-outline" href="#">Edytuj</a><a class="btn" href="#">+ Instalacja</a></div>
                </article>
                <article class="card">
                    <header class="card-head">
                        <h3><?= htmlspecialchars($installation['title']) ?></h3>
                        <span class="chip chip-warn">Przegląd <?= htmlspecialchars($installation['inspection']) ?></span>
                    </header>
                    <div class="table-wrap">
                        <table>
                            <thead><tr><th scope="col">Urządzenie</th><th scope="col">Lokalizacja</th><th scope="col">Montaż</th><th scope="col">Stan</th></tr></thead>
                            <tbody>
                                <?php foreach ($installation['devices'] as $d): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($d['name']) ?></td>
                                        <td><?= htmlspecialchars($d['place']) ?></td>
                                        <td><?= htmlspecialchars($d['date']) ?></td>
                                        <td><span class="chip chip-<?= htmlspecialchars($d['tone']) ?>"><?= htmlspecialchars($d['state']) ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <p class="toolbar"><a href="/protocols">Utwórz protokół prac</a> <a href="/tickets">Zobacz zgłoszenia</a></p>
                </article>
            </section>
        </div>
    </main>
</div>
<?php require __DIR__ . '/partials/foot.html.php'; ?>
