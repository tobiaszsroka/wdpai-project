<?php require __DIR__ . '/partials/head.html.php'; ?>
<div class="app">
    <?php require __DIR__ . '/partials/sidebar.html.php'; ?>
    <main class="content">
        <header class="page-head">
            <h1>Zgłoszenia serwisowe</h1>
            <a class="btn" href="#">+ Nowe zgłoszenie</a>
        </header>
        <form class="filters" method="get" action="/tickets">
            <div class="field"><label for="status">Status</label>
                <select id="status" name="status"><option>Wszystkie</option><option>Nowe</option><option>W toku</option><option>Zakończone</option></select></div>
            <div class="field"><label for="tech">Technik</label>
                <select id="tech" name="tech"><option>Wszyscy</option><?php foreach ($technicians as $t): ?><option><?= htmlspecialchars($t) ?></option><?php endforeach; ?></select></div>
            <div class="field"><label for="q">Szukaj</label>
                <input id="q" name="q" type="search" placeholder="Klient lub numer"></div>
        </form>
        <section class="card" aria-label="Lista zgłoszeń">
            <div class="table-wrap">
                <table>
                    <thead><tr><th scope="col">Nr</th><th scope="col">Klient</th><th scope="col">Kategoria</th><th scope="col">Zgłoszono</th><th scope="col">Przypisany technik</th><th scope="col">Status</th></tr></thead>
                    <tbody>
                        <?php foreach ($tickets as $t): ?>
                            <tr>
                                <td><strong>#<?= (int) $t['id'] ?></strong></td>
                                <td><?= htmlspecialchars($t['client']) ?></td>
                                <td><?= htmlspecialchars($t['category']) ?></td>
                                <td><?= htmlspecialchars($t['created']) ?></td>
                                <td>
                                    <?php if ($t['technician'] === null): ?>
                                        <label for="assign-<?= (int) $t['id'] ?>" style="position:absolute;left:-9999px">Przypisz technika do zgłoszenia <?= (int) $t['id'] ?></label>
                                        <select id="assign-<?= (int) $t['id'] ?>"><option>Wybierz technika…</option><?php foreach ($technicians as $n): ?><option><?= htmlspecialchars($n) ?></option><?php endforeach; ?></select>
                                    <?php else: ?>
                                        <?= htmlspecialchars($t['technician']) ?>
                                    <?php endif; ?>
                                </td>
                                <td><span class="chip chip-<?= htmlspecialchars($t['tone']) ?>"><?= htmlspecialchars($t['status']) ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <p class="note">Klient dostaje e-mail przy każdej zmianie statusu zgłoszenia.</p>
    </main>
</div>
<?php require __DIR__ . '/partials/foot.html.php'; ?>
