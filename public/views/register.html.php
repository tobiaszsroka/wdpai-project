<?php
/** @var array<string, string> $errors */
/** @var string $name */
/** @var string $email */
require __DIR__ . '/partials/head.html.php';
?>
<div class="auth">
    <section class="auth-brand">
        <div class="logo"><span class="logo-mark" aria-hidden="true">✓</span> SerwisBook</div>
        <div>
            <h1>Załóż konto klienta.</h1>
            <p>Po rejestracji zobaczysz swoje instalacje i zgłosisz usterkę w kilka chwil.</p>
        </div>
        <p class="note on-dark">Konta techników tworzy administrator firmy instalacyjnej.</p>
    </section>
    <main class="auth-form">
        <div>
            <div class="tabs">
                <a href="/login">Logowanie</a>
                <a href="/register" aria-current="page">Rejestracja klienta</a>
            </div>
            <?php if ($errors !== []): ?>
                <p class="error-box" role="alert">Popraw zaznaczone pola i wyślij formularz ponownie.</p>
            <?php endif; ?>
            <form method="post" action="/register" novalidate>
                <?php require __DIR__ . '/partials/csrf-field.html.php'; ?>
                <div class="field">
                    <label for="name">Imię i nazwisko</label>
                    <input id="name" name="name" type="text" value="<?= htmlspecialchars($name) ?>" autocomplete="name" required<?= isset($errors['name']) ? ' aria-invalid="true" aria-describedby="name-error"' : '' ?>>
                    <?php if (isset($errors['name'])): ?><p class="field-error" id="name-error"><?= htmlspecialchars($errors['name']) ?></p><?php endif; ?>
                </div>
                <div class="field">
                    <label for="email">Adres e-mail</label>
                    <input id="email" name="email" type="email" value="<?= htmlspecialchars($email) ?>" autocomplete="username" required<?= isset($errors['email']) ? ' aria-invalid="true" aria-describedby="email-error"' : '' ?>>
                    <?php if (isset($errors['email'])): ?><p class="field-error" id="email-error"><?= htmlspecialchars($errors['email']) ?></p><?php endif; ?>
                </div>
                <div class="field">
                    <label for="password">Hasło (min. 8 znaków)</label>
                    <input id="password" name="password" type="password" minlength="8" autocomplete="new-password" required<?= isset($errors['password']) ? ' aria-invalid="true" aria-describedby="password-error"' : '' ?>>
                    <?php if (isset($errors['password'])): ?><p class="field-error" id="password-error"><?= htmlspecialchars($errors['password']) ?></p><?php endif; ?>
                </div>
                <div class="field">
                    <label for="passwordConfirmation">Powtórz hasło</label>
                    <input id="passwordConfirmation" name="passwordConfirmation" type="password" minlength="8" autocomplete="new-password" required<?= isset($errors['passwordConfirmation']) ? ' aria-invalid="true" aria-describedby="passwordConfirmation-error"' : '' ?>>
                    <?php if (isset($errors['passwordConfirmation'])): ?><p class="field-error" id="passwordConfirmation-error"><?= htmlspecialchars($errors['passwordConfirmation']) ?></p><?php endif; ?>
                </div>
                <button type="submit" class="btn btn-block">Załóż konto</button>
            </form>
        </div>
    </main>
</div>
<?php require __DIR__ . '/partials/foot.html.php'; ?>
