<?php require __DIR__ . '/../partials/head.html.php'; ?>
<main class="phone phone-login">
    <header>
        <span class="logo-mark" aria-hidden="true">✓</span>
        <h1>SerwisBook</h1>
        <p class="muted">Książka serwisowa instalacji alarmowych i monitoringu. Wszystko o Twojej instalacji w jednym miejscu.</p>
    </header>
    <form method="post" action="/m/login">
        <div class="field"><label for="email">Adres e-mail</label><input id="email" name="email" type="email" placeholder="jan.kowalski@example.com" required></div>
        <div class="field"><label for="password">Hasło</label><input id="password" name="password" type="password" placeholder="••••••••" required></div>
        <button type="submit" class="btn btn-block">Zaloguj się</button>
        <p class="text-center mt-3"><a href="#">Nie pamiętam hasła</a></p>
    </form>
    <section class="brand-box mt-auto">
        <p>Jesteś klientem firmy instalacyjnej i nie masz jeszcze konta?</p>
        <p><a href="#"><strong>Zarejestruj się</strong></a></p>
    </section>
</main>
<?php require __DIR__ . '/../partials/foot.html.php'; ?>
