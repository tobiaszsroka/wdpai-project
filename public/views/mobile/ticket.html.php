<?php require __DIR__ . '/../partials/head.html.php'; ?>
<div class="phone">
    <header class="phone-head">
        <a href="/m/tasks">‹ Moje zadania</a>
        <div class="row"><h1 class="title-md">Zgłoszenie #<?= (int) $ticket['id'] ?></h1><span class="chip chip-warn"><?= htmlspecialchars($ticket['status']) ?></span></div>
    </header>
    <main class="phone-body">
        <section class="card">
            <h2 class="title-sm"><?= htmlspecialchars($ticket['title']) ?></h2>
            <p class="muted"><?= htmlspecialchars($ticket['place']) ?></p>
            <p class="description"><?= htmlspecialchars($ticket['description']) ?></p>
        </section>
        <section>
            <h2 class="muted title-xs">Zdjęcia</h2>
            <div class="photos"><div>Zdjęcie klienta</div><div>Zdjęcie klienta</div><button type="button">+ Dodaj</button></div>
        </section>
        <section class="card">
            <h2 class="muted title-xs">Historia</h2>
            <?php foreach ($ticket['history'] as [$when, $what]): ?>
                <p class="history-item"><strong><?= htmlspecialchars($when) ?></strong> · <?= htmlspecialchars($what) ?></p>
            <?php endforeach; ?>
        </section>
        <form method="post" action="/m/tasks/<?= (int) $ticket['id'] ?>">
            <div class="field"><label for="status">Zmień status</label>
                <select id="status" name="status"><option>Przypisane</option><option>W toku</option><option>Oczekuje na część</option><option>Zakończone</option></select></div>
            <div class="actions-row">
                <button type="submit" class="btn">Zapisz status</button>
                <a class="btn btn-outline" href="/protocols">Utwórz protokół</a>
            </div>
        </form>
    </main>
</div>
<?php require __DIR__ . '/../partials/foot.html.php'; ?>
