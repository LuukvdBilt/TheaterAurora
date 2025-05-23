<?php
session_start();

// Pad naar config.php (aangepast voor jouw structuur)
require_once __DIR__ . '/../../DB/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gebruikersnaam = $_POST['gebruikersnaam'] ?? '';
    $wachtwoord = $_POST['wachtwoord'] ?? '';

    try {
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Selecteer gebruiker
        $stmt = $pdo->prepare("SELECT * FROM Gebruiker WHERE Gebruikersnaam = :gebruikersnaam AND Wachtwoord = :wachtwoord AND Isactief = 1");
        $stmt->execute([
            ':gebruikersnaam' => $gebruikersnaam,
            ':wachtwoord' => $wachtwoord,
        ]);

        $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($gebruiker) {
            // Update ingelogd status
            $update = $pdo->prepare("UPDATE Gebruiker SET IsIngelogd = 1, Ingelogd = NOW() WHERE Id = :id");
            $update->execute([':id' => $gebruiker['Id']]);

            $_SESSION['user_id'] = $gebruiker['Id'];
            $_SESSION['gebruikersnaam'] = $gebruiker['Gebruikersnaam'];

            // Popup en redirect naar account overzicht in 'account' map
            echo "<script>alert('Succesvol ingelogd!'); window.location.href = '../../account/accountOverzicht.php';</script>";
            exit;
        } else {
            $error = "Ongeldige gebruikersnaam of wachtwoord.";
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
    <title>Login</title>
    <link rel="stylesheet" href="../style.css">
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

    <h2>Login</h2>
    <?php if (!empty($error)) : ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <label for="gebruikersnaam">Gebruikersnaam:</label>
        <input type="text" id="gebruikersnaam" name="gebruikersnaam" required><br><br>

        <label for="wachtwoord">Wachtwoord:</label>
        <input type="password" id="wachtwoord" name="wachtwoord" required><br><br>

        <button type="submit">Inloggen</button>
    </form>
</body>
</html>
