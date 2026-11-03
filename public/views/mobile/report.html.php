<?php require __DIR__ . '/../partials/head.html.php'; ?>
<div class="phone">
    <header class="phone-head">
        <h1>Zgłoś usterkę</h1>
        <p>Opisz problem, a firma serwisowa się z Tobą skontaktuje.</p>
    </header>
    <form class="phone-body" method="post" action="/m/report" enctype="multipart/form-data">
        <div class="field"><label for="installation">Instalacja</label>
            <select id="installation" name="installation"><?php foreach ($installations as $i): ?><option><?= htmlspecialchars($i) ?></option><?php endforeach; ?></select></div>
        <div class="field"><label for="category">Kategoria problemu</label>
            <select id="category" name="category"><?php foreach ($categories as $c): ?><option><?= htmlspecialchars($c) ?></option><?php endforeach; ?></select></div>
        <div class="field"><label for="description">Opis usterki</label>
            <textarea id="description" name="description" rows="4" placeholder="Np. kamera od strony ogrodu pokazuje czarny obraz od wczoraj"></textarea></div>
        <div class="field"><label for="photo">Zdjęcie (opcjonalnie)</label>
            <input id="photo" name="photo" type="file" accept="image/*"></div>
        <p class="info-box">Po wysłaniu dostaniesz numer zgłoszenia i powiadomienie e-mail o zmianie statusu.</p>
        <button type="submit" class="btn btn-block mt-auto">Wyślij zgłoszenie</button>
    </form>
</div>
<?php require __DIR__ . '/../partials/foot.html.php'; ?>
