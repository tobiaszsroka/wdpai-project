# AGENTS.md

## Cel projektu
SerwisBook: książka serwisowa instalacji alarmowych i monitoringu wizyjnego ze zgłoszeniami serwisowymi i generatorem protokołów prac. Aplikacja edukacyjna w PHP 8.3 (własny framework MVC), uruchamiana przez Docker Compose. Opis dla ludzi jest w `README.md`.

## Struktura
- `public/index.php`: punkt wejścia i lista tras.
- `src/Routing.php`: dopasowanie tras do kontrolerów (parametr `{id}` przyjmuje tylko cyfry).
- `src/controllers/`: kontrolery w namespace `App\Controller`, dziedziczą po `AppController`.
- `public/views/`: widoki `*.html.php`. Wspólne fragmenty są w `public/views/partials/`, widoki mobilne w `public/views/mobile/`.
- `public/css/style.css`: jedyny arkusz stylów (zmienne CSS, mobile first). `public/js/theme.js`: przełącznik motywu.
- `docker/`: Dockerfile'e usług, `docker-compose.yaml` w katalogu głównym.

## Zasady pracy
- Zachowuj `declare(strict_types=1)` w plikach PHP i autoloading PSR-4 (Composer). Nie dodawaj ręcznych `require` klas.
- Nie dodawaj frameworków ani zależności bez zgody.
- Kontroler przygotowuje dane i wywołuje `render()`, widok odpowiada tylko za prezentację.
- Dane wypisywane w HTML zabezpieczaj przez `htmlspecialchars()` (liczby rzutuj na `(int)`).
- Style trzymaj w `style.css` w klasach i z użyciem zmiennych CSS. Nie dodawaj stylów inline ani `!important`.
- Wprowadzaj małe zmiany i nie modyfikuj plików niezwiązanych z zadaniem. Zachowuj istniejące adresy tras.
- Aplikacja nie przechowuje kodów alarmowych ani haseł do urządzeń. Nie dodawaj takich pól.

## Uruchamianie i weryfikacja
- Start: `docker compose up --build -d`, potem `docker compose exec php composer dump-autoload`.
- Składnia: `docker compose exec -T php php -l ścieżka/do/pliku.php`.
- Po zmianie trasy sprawdź poprawny adres oraz odpowiedź 404 dla nieistniejącego.
- Po zmianie CSS sprawdź szerokości 360, 768 i 1440 px oraz brak poziomego przewijania.
- Testów automatycznych jeszcze nie ma.
- Przed zakończeniem pokaż `git diff` i podsumuj zmienione pliki.

## Git
- Osobny branch na każdą zmianę, merge przez pull request opcją „Create a merge commit” (bez squash, bez force push).
- Małe commity z prefiksem: `feat`, `fix`, `docs`, `refactor`, `test`, `chore` (np. `feat: add registration form`).
- Nie dopisuj do commitów linii „Co-Authored-By”.

## Bezpieczeństwo
- Nie odczytuj ani nie commituj sekretów z `.env`. Wzorem jest `.env.example`.
- Nie wykonuj destrukcyjnych poleceń (usuwanie plików i gałęzi, `git reset --hard`, `git push --force`) bez potwierdzenia.
- Nie zmieniaj wygenerowanych plików w `vendor/`.
