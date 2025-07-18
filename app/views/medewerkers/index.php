<?php require_once APPROOT . '/views/includes/header.php'; ?>

<!-- Pagina titel, en hierboven is de APPROOT om de header in te laden -->
<div class="container mt-3">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
            <h3><?= $data['title']; ?></h3>
        </div>
        <div class="col-1"></div>
    </div>

    <!-- Melding als het record succesvol is verwijderd -->
    <div class="row mt-3" style="display:<?= $data['message']; ?>;">
        <div class="col-1"></div>
        <div class="col-10">
            <div class="alert alert-danger" role="alert">
                Het record is verwijderd
            </div>
        </div>
        <div class="col-1"></div>
    </div>

    <!-- Knop om een nieuwe medewerker toe te voegen -->
    <div class="row mt-3 mb-2">
        <div class="col-1"></div>
        <div class="col-10">
            <a class="btn btn-outline-danger" href="<?= URLROOT; ?>/medewerkers/create" role="button">
                Nieuwe medewerker
            </a>
        </div>
        <div class="col-1"></div>
    </div>

    <!-- De tabel zelf -->
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>GebruikerId</th>
                        <th>Nummer</th>
                        <th>Soort</th>
                        <th>Actief</th>
                        <th>Opmerking</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <!-- Data ophalen en in de tabel zetten -->
                <tbody>
                    <?php foreach ($data['medewerkers'] as $medewerker) : ?>
                        <tr>
                            <td><?= $medewerker->Id; ?></td>
                            <td><?= $medewerker->GebruikerId; ?></td>
                            <td><?= $medewerker->Nummer; ?></td>
                            <td><?= $medewerker->Medewerkersoort; ?></td>
                            <td><?= $medewerker->Isactief ? 'Ja' : 'Nee'; ?></td>
                            <td><?= $medewerker->Opmerking; ?></td>
                            <!-- Hier aparte knoppen, verwijderen en wijzigen van medewerkers -->
                            <td>
                                <a href="<?= URLROOT; ?>/medewerkers/update/<?= $medewerker->Id; ?>" class="btn btn-sm btn-success">
                                    Wijzig
                                </a>
                            </td>
                            <td>
                                <a href="<?= URLROOT; ?>/medewerkers/delete/<?= $medewerker->Id; ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return bevestigDelete(this);"
                                    data-isactief="<?= $medewerker->Isactief; ?>">
                                    Verwijder
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Link om terug naar de dashboard te gaan -->
            <a href="<?= URLROOT; ?>/dashboard/index">Terug naar dashboard</a>
        </div>
        <div class="col-1"></div>
    </div>
</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
