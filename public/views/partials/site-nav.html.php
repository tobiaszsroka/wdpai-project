<header class="site-header">
    <nav class="site-nav" aria-label="Nawigacja główna">
        <a href="/" class="site-nav-brand">SerwisBook</a>
        <?php if ($currentUser === null): ?>
            <a href="/login">Zaloguj się</a>
            <a href="/register">Rejestracja</a>
        <?php else: ?>
            <a href="/installations">Instalacje</a>
            <a href="<?= htmlspecialchars($currentUser['role']->homePath()) ?>">Moje konto</a>
        <?php endif; ?>
    </nav>
</header>
