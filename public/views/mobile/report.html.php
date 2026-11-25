<?php
/** @var array<int, string> $installations */
/** @var list<string> $categories */
/** @var array<string, string> $errors */
/** @var \App\Dto\ReportTicketData|null $data */
/** @var int|null $createdId */
$selectedInstallation = $data?->installationId;
$selectedCategory = $data?->category;
require __DIR__ . '/../partials/head.html.php';
?>
<div class="phone">
    <header class="phone-head">
        <h1>Zgłoś usterkę</h1>
        <p>Opisz problem, a firma serwisowa się z Tobą skontaktuje.</p>
    </header>
    <form class="phone-body" method="post" action="/m/report" enctype="multipart/form-data" novalidate>
        <?php if ($createdId !== null): ?>
            <p class="success-box" role="status">Zgłoszenie #<?= (int) $createdId ?> zostało przyjęte.</p>
        <?php endif; ?>
        <?php if ($errors !== []): ?>
            <p class="error-box" role="alert">Popraw zaznaczone pola i wyślij formularz ponownie.</p>
        <?php endif; ?>
        <div class="field"><label for="installation">Instalacja</label>
            <select id="installation" name="installation" required<?= isset($errors['installation']) ? ' aria-invalid="true" aria-describedby="installation-error"' : '' ?>>
                <?php foreach ($installations as $id => $label): ?>
                    <option value="<?= (int) $id ?>"<?= $selectedInstallation === $id ? ' selected' : '' ?>><?= htmlspecialchars($label) ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errors['installation'])): ?><p class="field-error" id="installation-error"><?= htmlspecialchars($errors['installation']) ?></p><?php endif; ?></div>
        <div class="field"><label for="category">Kategoria problemu</label>
            <select id="category" name="category" required<?= isset($errors['category']) ? ' aria-invalid="true" aria-describedby="category-error"' : '' ?>>
                <?php foreach ($categories as $category): ?>
                    <option<?= $selectedCategory === $category ? ' selected' : '' ?>><?= htmlspecialchars($category) ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errors['category'])): ?><p class="field-error" id="category-error"><?= htmlspecialchars($errors['category']) ?></p><?php endif; ?></div>
        <div class="field"><label for="description">Opis usterki</label>
            <textarea id="description" name="description" rows="4" required placeholder="Np. kamera od strony ogrodu pokazuje czarny obraz od wczoraj"<?= isset($errors['description']) ? ' aria-invalid="true" aria-describedby="description-error"' : '' ?>><?= htmlspecialchars($data?->description ?? '') ?></textarea>
            <?php if (isset($errors['description'])): ?><p class="field-error" id="description-error"><?= htmlspecialchars($errors['description']) ?></p><?php endif; ?></div>
        <div class="field"><label for="photo">Zdjęcie (opcjonalnie)</label>
            <input id="photo" name="photo" type="file" accept="image/*"></div>
        <p class="info-box">Po wysłaniu dostaniesz numer zgłoszenia i powiadomienie e-mail o zmianie statusu.</p>
        <button type="submit" class="btn btn-block mt-auto">Wyślij zgłoszenie</button>
    </form>
</div>
<?php require __DIR__ . '/../partials/foot.html.php'; ?>
