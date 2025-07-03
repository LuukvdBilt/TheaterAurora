<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../account2/login/login.php");
    exit;
}

require_once __DIR__ . '/../DB/config.php';

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT * FROM Gebruiker");
    $gebruikers = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Databasefout: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Overzicht van de Accounts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
    <div class="logo">
        <img src="/Images/Theater-logo.png" id="LOGO">
    </div>
    <div>
        <a href="../index.html">Home</a>
        <a href="#">Voorstellingen</a>
        <a href="#">Contact</a>
        <a href="../account2/login/login.php">Login</a>
    </div>
</nav>

<div class="container mt-4">
    <h2 class="mb-4">Overzicht van de Accounts</h2>

    <!-- ✅ Toevoegknop -->
    <div class="mb-3">
        <a href="create.php" class="btn btn-success">Account toevoegen</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Id</th>
            <th>Voornaam</th>
            <th>Tussenvoegsel</th>
            <th>Achternaam</th>
            <th>Gebruikersnaam</th>
            <th>Wachtwoord</th>
            <th>Ingelogd</th>
            <th>Uitgelogd</th>
            <th>Is Ingelogd</th>
            <th>Acties</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($gebruikers as $rij): ?>
            <tr>
                <td><?= htmlspecialchars($rij['Id'] ?? '') ?></td>
                <td><?= htmlspecialchars($rij['Voornaam'] ?? '') ?></td>
                <td><?= htmlspecialchars($rij['Tussenvoegsel'] ?? '') ?></td>
                <td><?= htmlspecialchars($rij['Achternaam'] ?? '') ?></td>
                <td><?= htmlspecialchars($rij['Gebruikersnaam'] ?? '') ?></td>
                <td><?= htmlspecialchars($rij['Wachtwoord'] ?? '') ?></td>
                <td><?= isset($rij['Ingelogd']) && $rij['Ingelogd'] ? 'Ja' : 'Nee' ?></td>
                <td><?= htmlspecialchars($rij['Uitgelogd'] ?? '') ?></td>
                <td><?= isset($rij['IsIngelogd']) && $rij['IsIngelogd'] ? 'Ja' : 'Nee' ?></td>
                <td>
                    <a href="update.php?Id=<?= $rij['Id'] ?>" class="btn btn-sm btn-primary me-1">
                        Wijzigen
                    </a>
                    <a href="delete.php?Id=<?= $rij['Id'] ?>" class="btn btn-sm btn-danger"
                       onclick="return confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?');">
                        Verwijderen
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
