<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container mt-3">

    <div class="row mb-3">
        <div class="col-3"></div>
        <div class="col-6">
            <h3><?= $data['title']; ?></h3>
        </div>
        <div class="col-3"></div>
    </div>
    <?php if (!empty($data['error'])): ?>
    <div class="alert alert-danger" role="alert">
        <?= $data['error']; ?>
    </div>
<?php endif; ?>


    <div class="row mb-3"style="display:<?= $data['message']; ?>" >
        <div class="col-3"></div>
        <div class="col-6">
            <div class="alert alert-success" role="alert">
                Het record is gewijzigd
            </div>
        </div>
        <div class="col-3"></div>
    </div>
       
    <div class="row mb-3">
        <div class="col-3"></div>
        <div class="col-6">
    <?php if ($data['medewerker']): ?>
        <form action="<?= URLROOT; ?>/medewerkers/update/<?= $data['medewerker']->Id ?>" method="post">
            <div class="mb-3">
                <label for="gebruikerid" class="form-label">GebruikerId</label>
                <input value="<?= $data['medewerker']->GebruikerId; ?>" type="number" class="form-control" id="gebruikerid" name="gebruikerid" required>
            </div>
            <div class="mb-3">
                <label for="nummer" class="form-label">Nummer</label>
                <input value="<?= $data['medewerker']->Nummer; ?>"  type="number" class="form-control" id="nummer" name="nummer" required>
            </div>
            <div class="mb-3">
                <label for="soort" class="form-label">Soort</label>
                <input value="<?= $data['medewerker']->Medewerkersoort; ?>"  type="text" class="form-control" id="soort" name="soort" required>
            </div>
            <div class="mb-3">
                <label for="isactief" class="form-label">Actief</label>
                <input <?= $data['medewerker']->Isactief ? 'checked' : '' ?> type="checkbox" id="isactief" name="isactief" value="1">
            </div>
            <div class="mb-3">
                <label for="opmerking" class="form-label">Opmerking</label>
                <input value="<?= $data['medewerker']->Opmerking; ?>"  type="text" class="form-control" id="opmerking" name="opmerking">
            </div>
            <button type="submit" class="btn btn-primary">Opslaan</button>
        </form>
    <?php else: ?>
        <div class="alert alert-danger">Medewerker niet gevonden!</div>
    <?php endif; ?>
</div>
        <div class="col-3"></div>
    </div>


<?php require_once APPROOT . '/views/includes/footer.php'; ?> 