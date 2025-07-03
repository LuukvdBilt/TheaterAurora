<?php
session_start();

// Alleen ingelogde gebruikers mogen dit doen
if (!isset($_SESSION['user_id'])) {
    header("Location: ../account2/login/login.php");
    exit;
}

require_once('../DB/config.php');

if (isset($_POST['submit'])) {
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    try {
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check of gebruikersnaam al bestaat
        $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM Gebruiker WHERE Gebruikersnaam = :gebruikersnaam");
        $stmtCheck->bindValue(':gebruikersnaam', trim($_POST['Gebruikersnaam']), PDO::PARAM_STR);
        $stmtCheck->execute();

        if ($stmtCheck->fetchColumn() > 0) {
            $error = "Deze gebruikersnaam bestaat al. Kies een andere.";
        } else {
            // Insert nieuwe gebruiker
            $stmt = $pdo->prepare("
                INSERT INTO Gebruiker (
                    Voornaam, Tussenvoegsel, Achternaam, Gebruikersnaam, Wachtwoord,
                    IsIngelogd, Isactief, Opmerking, Datumaangemaakt, Datumgewijzigd
                ) VALUES (
                    :voornaam, :tussenvoegsel, :achternaam, :gebruikersnaam, :wachtwoord,
                    0, 1, NULL, NOW(6), NOW(6)
                )
            ");

            $stmt->bindValue(':voornaam', trim($_POST['Voornaam']), PDO::PARAM_STR);
            $stmt->bindValue(':tussenvoegsel', trim($_POST['Tussenvoegsel']), PDO::PARAM_STR);
            $stmt->bindValue(':achternaam', trim($_POST['Achternaam']), PDO::PARAM_STR);
            $stmt->bindValue(':gebruikersnaam', trim($_POST['Gebruikersnaam']), PDO::PARAM_STR);
            $stmt->bindValue(':wachtwoord', password_hash(trim($_POST['Wachtwoord']), PASSWORD_DEFAULT), PDO::PARAM_STR);

            $stmt->execute();

            // Na succesvol toevoegen: direct door naar overzicht
            header("Location: accountOverzicht.php");
            exit;
        }
    } catch (PDOException $e) {
        $error = "Fout bij opslaan: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Nieuwe Gebruiker Toevoegen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Nieuwe Gebruiker Toevoegen</h3>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>

    <form action="create.php" method="POST">
        <div class="mb-3">
            <label for="Voornaam" class="form-label">Voornaam</label>
            <input type="text" name="Voornaam" class="form-control" required value="<?= $_POST['Voornaam'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label for="Tussenvoegsel" class="form-label">Tussenvoegsel</label>
            <input type="text" name="Tussenvoegsel" class="form-control" value="<?= $_POST['Tussenvoegsel'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label for="Achternaam" class="form-label">Achternaam</label>
            <input type="text" name="Achternaam" class="form-control" required value="<?= $_POST['Achternaam'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label for="Gebruikersnaam" class="form-label">Gebruikersnaam</label>
            <input type="text" name="Gebruikersnaam" class="form-control" required value="<?= $_POST['Gebruikersnaam'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label for="Wachtwoord" class="form-label">Wachtwoord</label>
            <input type="password" name="Wachtwoord" class="form-control" required>
        </div>
        <div class="d-grid">
            <button type="submit" name="submit" class="btn btn-success">Gebruiker Aanmaken</button>
        </div>
    </form>
</div>
</body>
</html>
