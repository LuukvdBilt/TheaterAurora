<?php
session_start();

// Als gebruiker al is ingelogd, stuur door
if (isset($_SESSION['gebruiker_id'])) {
    header("Location: dashboard.php");
    exit;
}

// Check of formulier is ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('../DB/config.php');

    $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";
    try {
        $pdo = new PDO($dsn, $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $gebruikersnaam = $_POST['gebruikersnaam'];
        $wachtwoord = $_POST['wachtwoord'];

        $sql = "SELECT Id, Wachtwoord FROM Gebruiker WHERE Gebruikersnaam = :gebruikersnaam AND Isactief = 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['gebruikersnaam' => $gebruikersnaam]);
        $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($gebruiker && password_verify($wachtwoord, $gebruiker['Wachtwoord'])) {
            $_SESSION['gebruiker_id'] = $gebruiker['Id'];
            header("Location: dashboard.php");
            exit;
        } else {
            $foutmelding = "Ongeldige gebruikersnaam of wachtwoord.";
        }

    } catch (PDOException $e) {
        die("Databasefout: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Inloggen</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h2>Inloggen</h2>

    <?php if (isset($foutmelding)) : ?>
        <p style="color:red;"><?= htmlspecialchars($foutmelding) ?></p>
    <?php endif; ?>

    <form method="post" action="login.php">
        <label>Gebruikersnaam:</label><br>
        <input type="text" name="gebruikersnaam" required><br><br>

        <label>Wachtwoord:</label><br>
        <input type="password" name="wachtwoord" required><br><br>

        <input type="submit" value="Inloggen">
    </form>
</body>
</html>
