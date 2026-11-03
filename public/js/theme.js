// Przełącznik motywu: zapisuje wybór w localStorage i ustawia data-theme na <html>.
(function () {
    var root = document.documentElement;
    try {
        var saved = localStorage.getItem('theme');
        if (saved === 'dark' || saved === 'light') {
            root.setAttribute('data-theme', saved);
        }
    } catch (e) { /* przeglądarka bez dostępu do localStorage */ }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-theme-toggle]').forEach(function (button) {
            button.addEventListener('click', function () {
                var next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
                root.setAttribute('data-theme', next);
                try { localStorage.setItem('theme', next); } catch (e) { /* ignoruj */ }
            });
        });
    });
})();
