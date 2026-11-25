<?php require __DIR__ . '/../partials/head.html.php'; ?>
<div class="phone">
    <header class="phone-head">
        <a href="/m/tasks">‹ Moje zadania</a>
        <div class="row"><h1 class="title-md">Zgłoszenie #<?= $ticket->getId() ?></h1><span class="chip chip-<?= htmlspecialchars($ticket->getStatus()->tone()) ?>"><?= htmlspecialchars($ticket->getStatus()->label()) ?></span></div>
    </header>
    <main class="phone-body">
        <section class="card">
            <h2 class="title-sm"><?= htmlspecialchars($ticket->getTitle()) ?></h2>
            <p class="muted"><?= htmlspecialchars($ticket->getPlace()) ?></p>
            <p class="description"><?= htmlspecialchars($ticket->getDescription()) ?></p>
        </section>
        <section>
            <h2 class="muted title-xs">Zdjęcia</h2>
            <div class="photos"><div>Zdjęcie klienta</div><div>Zdjęcie klienta</div><button type="button">+ Dodaj</button></div>
        </section>
        <section class="card">
            <h2 class="muted title-xs">Historia</h2>
            <?php foreach ($ticket->getHistory() as [$at, $what]): ?>
                <p class="history-item"><strong><?= htmlspecialchars($at->format('d.m, H:i')) ?></strong> · <?= htmlspecialchars($what) ?></p>
            <?php endforeach; ?>
        </section>
        <form method="post" action="/m/tasks/<?= $ticket->getId() ?>">
            <?php require __DIR__ . '/../partials/csrf-field.html.php'; ?>
            <div class="field"><label for="status">Zmień status</label>
                <select id="status" name="status">
                    <?php foreach ($statuses as $status): ?>
                        <option value="<?= htmlspecialchars($status->value) ?>"<?= $ticket->getStatus() === $status ? ' selected' : '' ?>><?= htmlspecialchars($status->label()) ?></option>
                    <?php endforeach; ?>
                </select></div>
            <div class="actions-row">
                <button type="submit" class="btn">Zapisz status</button>
                <a class="btn btn-outline" href="/protocols">Utwórz protokół</a>
            </div>
        </form>
    </main>
</div>
<?php require __DIR__ . '/../partials/foot.html.php'; ?>
