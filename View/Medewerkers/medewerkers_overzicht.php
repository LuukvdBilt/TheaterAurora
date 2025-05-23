<?php

declare(strict_types=1);

require_once '../config/db_connect.php';

try {
    $sql = 'SELECT m.id, m.nummer, m.soort, m.status, m.opmerking, m.aangemaakt, m.gewijzigd, a.afdeling_naam
            FROM medewerkers m
            LEFT JOIN afdeling a ON m.afdeling_id = a.id
            ORDER BY m.id';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $medewerkers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  
    echo '<div class="alert alert-danger" role="alert">';
    echo 'Er is een fout opgetreden bij het ophalen van de medewerkers: ' . htmlspecialchars($e->getMessage());
    echo '</div>';
    exit;
}

?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medewerker Overzicht</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container-fluid">
        <main class="py-4">
            <h1>Medewerker Overzicht</h1>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nummer</th>
                        <th>Soort</th>
                        <th>Status</th>
                        <th>Opmerking</th>
                        <th>Aangemaakt</th>
                        <th>Gewijzigd</th>
                        <th>Afdeling</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($medewerkers as $medewerker) : ?>
                        <tr>
                            <td><?= htmlspecialchars($medewerker['id']) ?></td>
                            <td><?= htmlspecialchars($medewerker['nummer']) ?></td>
                            <td><?= htmlspecialchars($medewerker['soort']) ?></td>
                            <td><?= htmlspecialchars($medewerker['status']) ?></td>
                            <td><?= htmlspecialchars($medewerker['opmerking']) ?></td>
                            <td><?= htmlspecialchars($medewerker['aangemaakt']) ?></td>
                            <td><?= htmlspecialchars($medewerker['gewijzigd']) ?></td>
                            <td><?= htmlspecialchars($medewerker['afdeling_naam'] ?? 'Onbekend') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
<?php

declare(strict_types=1);

require_once '../config/db_connect.php';

try {
    $sql = 'SELECT m.id, m.nummer, m.soort, m.status, m.opmerking, m.aangemaakt, m.gewijzigd, a.afdeling_naam
            FROM medewerkers m
            LEFT JOIN afdeling a ON m.afdeling_id = a.id
            ORDER BY m.id';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $medewerkers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo '<div class="alert alert-danger" role="alert">';
    echo 'Er is een fout opgetreden bij het ophalen van de medewerkers: ' . htmlspecialchars($e->getMessage());
    echo '</div>';
    exit;
}

?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medewerker Overzicht</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container-fluid">
        <main class="py-4">
            <h1>Medewerker Overzicht</h1>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nummer</th>
                        <th>Soort</th>
                        <th>Status</th>
                        <th>Opmerking</th>
                        <th>Aangemaakt</th>
                        <th>Gewijzigd</th>
                        <th>Afdeling</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($medewerkers as $medewerker) : ?>
                        <tr>
                            <td><?= htmlspecialchars($medewerker['id']) ?></td>
                            <td><?= htmlspecialchars($medewerker['nummer']) ?></td>
                            <td><?= htmlspecialchars($medewerker['soort']) ?></td>
                            <td><?= htmlspecialchars($medewerker['status']) ?></td>
                            <td><?= htmlspecialchars($medewerker['opmerking']) ?></td>
                            <td><?= htmlspecialchars($medewerker['aangemaakt']) ?></td>
                            <td><?= htmlspecialchars($medewerker['gewijzigd']) ?></td>
                            <td><?= htmlspecialchars($medewerker['afdeling_naam'] ?? 'Onbekend') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
