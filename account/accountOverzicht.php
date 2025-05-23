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
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
    <div class="logo"> <img src="/Images/Theater-logo.png" id="LOGO"></div>
    <div>
      <a href="../index.html">Home</a>
      <a href="">Voorstellingen</a>
      <a href="">Contact</a>
      <a href="../account2/login/login.php">Login</a>
    </div>
</nav>

<h2>Overzicht van de Accounts</h2>

<table border="1" cellpadding="8" cellspacing="0">
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
    </tr>

    <?php foreach ($gebruikers as $rij): ?>
    <tr>
        <td><?= htmlspecialchars($rij['Id'] ?? '') ?></td>
        <td><?= htmlspecialchars($rij['Voornaam'] ?? '') ?></td>
        <td><?= htmlspecialchars($rij['Tussenvoegsel'] ?? '') ?></td>
        <td><?= htmlspecialchars($rij['Achternaam'] ?? '') ?></td>
        <td><?= htmlspecialchars($rij['Gebruikersnaam'] ?? '') ?></td>
        <td><?= htmlspecialchars($rij['Wachtwoord'] ?? '') ?></td>
        <td><?= isset($rij['Ingelogd']) && $rij['Ingelogd'] ? $rij['Ingelogd'] : '' ?></td>
        <td><?= htmlspecialchars($rij['Uitgelogd'] ?? '') ?></td>
        <td><?= isset($rij['IsIngelogd']) && $rij['IsIngelogd'] ? 'Ja' : 'Nee' ?></td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
