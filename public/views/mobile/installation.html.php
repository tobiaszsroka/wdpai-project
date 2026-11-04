<?php $active = 'installation'; require __DIR__ . '/../partials/head.html.php'; ?>
<div class="phone">
    <header class="phone-head">
        <p>Instalacja · <?= htmlspecialchars($installation->getClientName()) ?></p>
        <h1 class="title-md"><?= htmlspecialchars($installation->getTitle()) ?></h1>
        <p><?= htmlspecialchars($installation->getType()) ?> · uruchomiona <?= htmlspecialchars($installation->getInstalledAt()->format('d.m.Y')) ?></p>
    </header>
    <main class="phone-body">
        <p class="alert" role="status">
            <span><?php if ($daysLeft >= 0): ?>
                <strong>Przegląd roczny za <?= $daysLeft ?> dni</strong><br>
            <?php else: ?>
                <strong>Przegląd po terminie o <?= abs($daysLeft) ?> dni</strong><br>
            <?php endif; ?>
            <small>Termin: <?= htmlspecialchars($installation->getNextInspection()->format('d.m.Y')) ?><?php if ($installation->getInspectionNote() !== null): ?> · <?= htmlspecialchars($installation->getInspectionNote()) ?><?php endif; ?></small></span>
        </p>
        <h2 class="muted title-sm">Urządzenia (<?= count($installation->getDevices()) ?>)</h2>
        <ul class="list device-list">
            <?php foreach ($installation->getDevices() as $d): ?>
                <li class="device">
                    <span><strong><?= htmlspecialchars($d->getName()) ?></strong><small><?= htmlspecialchars($d->getPlace()) ?></small></span>
                    <span class="chip chip-<?= htmlspecialchars($d->getState()->tone()) ?>"><?= htmlspecialchars($d->getState()->label()) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
        <p class="note">Aplikacja nie przechowuje kodów alarmowych ani haseł do urządzeń.</p>
    </main>
    <?php require __DIR__ . '/../partials/tabbar.html.php'; ?>
</div>
<?php require __DIR__ . '/../partials/foot.html.php'; ?>
