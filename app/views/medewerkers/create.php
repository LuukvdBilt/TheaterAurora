<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container mt-3">

    <div class="row mb-3">
        <div class="col-3"></div>
        <div class="col-6">
            <h3><?= $data['title']; ?></h3>
        </div>
        <div class="col-3"></div>
    </div>
<!--als data leeg is een error-->
    <?php if (!empty($data['error'])): ?>
    <div class="alert alert-danger" role="alert">
        <?= $data['error']; ?>
    </div>
<?php endif; ?>

    <!--Als de medewerker succesvol is toegevoegd-->
    <div class="row mb-3" style="display:<?= $data['message']; ?>;">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="alert alert-success" role="alert">
                Het record is toegevoegd
            </div>
        </div>
        <div class="col-3"></div>
    </div>

    <!--model om een medewerker aan te maken-->
<div class="container mt-3">
    <form action="<?= URLROOT; ?>/medewerkers/create" method="post">
        <div class="mb-3">
            <label for="gebruikerid" class="form-label">GebruikerId</label>
            <input type="number" class="form-control" id="gebruikerid" name="gebruikerid" required>
        </div>
        <div class="mb-3">
            <label for="nummer" class="form-label">Nummer</label>
            <input type="number" class="form-control" id="nummer" name="nummer" min="1000" max="9999" required>
        </div>
        <div class="mb-3">
            <label for="soort" class="form-label">Soort</label>
            <input type="text" class="form-control" id="soort" name="soort" required>
        </div>
        <div class="mb-3">
            <label for="isactief" class="form-label">Actief</label>
            <input type="checkbox" id="isactief" name="isactief" value="1" checked>
        </div>
        <div class="mb-3">
            <label for="opmerking" class="form-label">Opmerking</label>
            <input type="text" class="form-control" id="opmerking" name="opmerking">
        </div>
        <button type="submit" class="btn btn-primary">Opslaan</button>
    </form>
</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>