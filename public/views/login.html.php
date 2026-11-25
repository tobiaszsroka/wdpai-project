<?php require __DIR__ . '/partials/head.html.php'; ?>
<div class="auth">
    <section class="auth-brand">
        <div class="logo"><span class="logo-mark" aria-hidden="true">✓</span> SerwisBook</div>
        <div>
            <h1>Cała dokumentacja Twojej instalacji w jednym miejscu.</h1>
            <p>Karty instalacji, zgłoszenia serwisowe, protokoły prac i przypomnienia o przeglądach dla firm instalacyjnych i ich klientów.</p>
        </div>
        <p class="note on-dark">Dla instalatorów alarmów, monitoringu wizyjnego i sieci.</p>
    </section>
    <main class="auth-form">
        <div>
            <div class="tabs">
                <a href="/login" aria-current="page">Logowanie</a>
                <a href="/register">Rejestracja klienta</a>
            </div>
            <?php if ($registered): ?>
                <p class="success-box" role="status">Konto zostało utworzone. Możesz się zalogować.</p>
            <?php endif; ?>
            <?php if ($errors !== []): ?>
                <p class="error-box" role="alert"><?= htmlspecialchars(implode(' ', $errors)) ?></p>
            <?php endif; ?>
            <form method="post" action="/login">
                <?php require __DIR__ . '/partials/csrf-field.html.php'; ?>
                <div class="field">
                    <label for="email">Adres e-mail</label>
                    <input id="email" name="email" type="email" value="<?= htmlspecialchars($email) ?>" placeholder="jan.kowalski@example.com" autocomplete="username" required>
                </div>
                <div class="field">
                    <label for="password">Hasło</label>
                    <input id="password" name="password" type="password" placeholder="••••••••" autocomplete="current-password" required>
                </div>
                <button type="submit" class="btn btn-block">Zaloguj się</button>
                <p><a href="#">Nie pamiętam hasła</a></p>
            </form>
            <section id="rejestracja" class="brand-box mt-4">
                <h2 class="title-sm">Pierwszy raz tutaj?</h2>
                <p>Klient zakłada konto, podając e-mail i hasło. Konta techników tworzy administrator firmy instalacyjnej.</p>
                <p><a href="/register">Załóż konto klienta</a></p>
            </section>
        </div>
    </main>
</div>
<?php require __DIR__ . '/partials/foot.html.php'; ?>
