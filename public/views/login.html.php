<?php require __DIR__ . '/partials/head.html.php'; ?>
<div class="auth">
    <section class="auth-brand">
        <div class="logo"><span class="logo-mark" aria-hidden="true">✓</span> SerwisBook</div>
        <div>
            <h1>Cała dokumentacja Twojej instalacji w jednym miejscu.</h1>
            <p>Karty instalacji, zgłoszenia serwisowe, protokoły prac i przypomnienia o przeglądach dla firm instalacyjnych i ich klientów.</p>
        </div>
        <p class="note" style="color:#BBD9E6">Dla instalatorów alarmów, monitoringu wizyjnego i sieci.</p>
    </section>
    <main class="auth-form">
        <div>
            <div class="tabs">
                <a href="/login" aria-current="page">Logowanie</a>
                <a href="/login#rejestracja">Rejestracja klienta</a>
            </div>
            <form method="post" action="/login">
                <div class="field">
                    <label for="email">Adres e-mail</label>
                    <input id="email" name="email" type="email" placeholder="jan.kowalski@example.com" required>
                </div>
                <div class="field">
                    <label for="password">Hasło</label>
                    <input id="password" name="password" type="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn btn-block">Zaloguj się</button>
                <p><a href="#">Nie pamiętam hasła</a></p>
            </form>
            <section id="rejestracja" class="brand-box" style="margin-top:24px">
                <h2 style="font-size:16px">Pierwszy raz tutaj?</h2>
                <p>Klient zakłada konto, podając e-mail i hasło. Konta techników tworzy administrator firmy instalacyjnej.</p>
            </section>
        </div>
    </main>
</div>
<?php require __DIR__ . '/partials/foot.html.php'; ?>
