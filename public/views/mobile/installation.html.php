<?php $active = 'installation'; require __DIR__ . '/../partials/head.html.php'; ?>
<div class="phone">
    <header class="phone-head">
        <p>Instalacja · <?= htmlspecialchars($installation['client']) ?></p>
        <h1 class="title-md"><?= htmlspecialchars($installation['address']) ?></h1>
        <p><?= htmlspecialchars($installation['type']) ?> · uruchomiona <?= htmlspecialchars($installation['since']) ?></p>
    </header>
    <main class="phone-body">
        <p class="alert" role="status">
            <span><strong>Przegląd roczny za <?= (int) $installation['daysLeft'] ?> dni</strong><br>
            <small>Termin: <?= htmlspecialchars($installation['inspection']) ?> · wymiana akumulatora centrali</small></span>
        </p>
        <h2 class="muted title-sm">Urządzenia (<?= count($installation['devices']) ?>)</h2>
        <ul class="list device-list">
            <?php foreach ($installation['devices'] as $d): ?>
                <li class="device">
                    <span><strong><?= htmlspecialchars($d['name']) ?></strong><small><?= htmlspecialchars($d['place']) ?></small></span>
                    <span class="chip chip-<?= htmlspecialchars($d['tone']) ?>"><?= htmlspecialchars($d['state']) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
        <p class="note">Aplikacja nie przechowuje kodów alarmowych ani haseł do urządzeń.</p>
    </main>
    <?php require __DIR__ . '/../partials/tabbar.html.php'; ?>
</div>
<?php require __DIR__ . '/../partials/foot.html.php'; ?>
