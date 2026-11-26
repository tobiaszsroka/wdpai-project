<?php require __DIR__ . '/../partials/head.html.php'; ?>
<main class="phone phone-login">
    <header>
        <span class="logo-mark" aria-hidden="true">✓</span>
        <h1>SerwisBook</h1>
        <p class="muted">Książka serwisowa instalacji alarmowych i monitoringu. Wszystko o Twojej instalacji w jednym miejscu.</p>
    </header>
    <?php if ($registered): ?>
        <p class="success-box" role="status">Konto zostało utworzone. Możesz się zalogować.</p>
    <?php endif; ?>
    <?php if ($errors !== []): ?>
        <p class="error-box" role="alert"><?= htmlspecialchars(implode(' ', $errors)) ?></p>
    <?php endif; ?>
    <form method="post" action="/m/login">
        <?php require __DIR__ . '/../partials/csrf-field.html.php'; ?>
        <div class="field"><label for="email">Adres e-mail</label><input id="email" name="email" type="email" value="<?= htmlspecialchars($email) ?>" placeholder="jan.kowalski@example.com" autocomplete="username" required></div>
        <div class="field"><label for="password">Hasło</label><input id="password" name="password" type="password" placeholder="••••••••" autocomplete="current-password" required></div>
        <button type="submit" class="btn btn-block">Zaloguj się</button>
        <p class="text-center mt-3"><a href="#">Nie pamiętam hasła</a></p>
    </form>
    <section class="brand-box mt-auto">
        <p>Jesteś klientem firmy instalacyjnej i nie masz jeszcze konta?</p>
        <p><a href="/register"><strong>Zarejestruj się</strong></a></p>
    </section>
</main>
<?php require __DIR__ . '/../partials/foot.html.php'; ?>
