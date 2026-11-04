<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> – SerwisBook</title>
    <script>
        // Ustawia motyw zanim przeglądarka zacznie renderować stronę (bez FOUC).
        // Kolejność: zapis użytkownika (localStorage) -> prefers-color-scheme.
        (function () {
            var savedTheme = null;

            try {
                savedTheme = localStorage.getItem('theme');
            } catch (error) {
                savedTheme = null;
            }

            var hasSavedTheme = savedTheme === 'light' || savedTheme === 'dark';
            var systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            document.documentElement.dataset.theme = hasSavedTheme
                ? savedTheme
                : (systemPrefersDark ? 'dark' : 'light');
        })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <?php require __DIR__ . '/theme-toggle.html.php'; ?>
