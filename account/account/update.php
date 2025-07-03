<?php
include('../DB/config.php');

$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";
$pdo = new PDO($dsn, $dbUser, $dbPass);

if (isset($_POST['submit'])) {
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Controleer of de gebruikersnaam al bestaat bij een ander gebruiker
    $sqlCheck = "SELECT COUNT(*) FROM Gebruiker WHERE Gebruikersnaam = :gebruikersnaam AND Id != :id";
    $checkStmt = $pdo->prepare($sqlCheck);
    $checkStmt->bindValue(':gebruikersnaam', $_POST['Gebruikersnaam'], PDO::PARAM_STR);
    $checkStmt->bindValue(':id', $_POST['Id'], PDO::PARAM_INT);
    $checkStmt->execute();
    $gebruikersnaamExists = $checkStmt->fetchColumn();

    if ($gebruikersnaamExists) {
        $error = "Deze gebruikersnaam is al in gebruik bij een andere gebruiker.";
    } else {
        // Wachtwoord hash alleen updaten als er een nieuw wachtwoord is ingevuld
        if (!empty($_POST['Wachtwoord'])) {
            $wachtwoordHash = password_hash($_POST['Wachtwoord'], PASSWORD_DEFAULT);
            $sql = "UPDATE Gebruiker SET
                        Voornaam = :voornaam,
                        Tussenvoegsel = :tussenvoegsel,
                        Achternaam = :achternaam,
                        Gebruikersnaam = :gebruikersnaam,
                        Wachtwoord = :wachtwoord,
                        Datumgewijzigd = SYSDATE(6)
                    WHERE Id = :id";
        } else {
            $sql = "UPDATE Gebruiker SET
                        Voornaam = :voornaam,
                        Tussenvoegsel = :tussenvoegsel,
                        Achternaam = :achternaam,
                        Gebruikersnaam = :gebruikersnaam,
                        Datumgewijzigd = SYSDATE(6)
                    WHERE Id = :id";
        }

        $statement = $pdo->prepare($sql);
        $statement->bindValue(':voornaam', trim($_POST['Voornaam']), PDO::PARAM_STR);
        $statement->bindValue(':tussenvoegsel', trim($_POST['Tussenvoegsel']), PDO::PARAM_STR);
        $statement->bindValue(':achternaam', trim($_POST['Achternaam']), PDO::PARAM_STR);
        $statement->bindValue(':gebruikersnaam', trim($_POST['Gebruikersnaam']), PDO::PARAM_STR);
        if (!empty($_POST['Wachtwoord'])) {
            $statement->bindValue(':wachtwoord', $wachtwoordHash, PDO::PARAM_STR);
        }
        $statement->bindValue(':id', trim($_POST['Id']), PDO::PARAM_INT);
        $statement->execute();

        // Directe redirect naar overzicht na update
        header('Location: accountOverzicht.php');
        exit;
    }
} else {
    $sql = "SELECT * FROM Gebruiker WHERE Id = :id";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $_GET['Id'], PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_OBJ);
}
?>
<!doctype html>
<html lang="nl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gebruiker Wijzigen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container mt-3">
      <?php if (isset($error)): ?>
        <div class="alert alert-danger text-center"><?= $error; ?></div>
      <?php endif; ?>

      <div class="row mb-1">
        <div class="col-3"></div>
        <div class="col-6 text-primary"><h3>Wijzig gebruikersgegevens</h3></div>
        <div class="col-3"></div>
      </div>

      <div class="row">
        <div class="col-3"></div>
        <div class="col-6">              
          <form action="update.php" method="POST">
            <div class="mb-3">
              <label for="Voornaam" class="form-label">Voornaam</label>
              <input name="Voornaam" type="text" class="form-control" id="Voornaam" value="<?= htmlspecialchars($result->Voornaam ?? $_POST['Voornaam']); ?>" required>
            </div>
            <div class="mb-3">
              <label for="Tussenvoegsel" class="form-label">Tussenvoegsel</label>
              <input name="Tussenvoegsel" type="text" class="form-control" id="Tussenvoegsel" value="<?= htmlspecialchars($result->Tussenvoegsel ?? $_POST['Tussenvoegsel']); ?>">
            </div>
            <div class="mb-3">
              <label for="Achternaam" class="form-label">Achternaam</label>
              <input name="Achternaam" type="text" class="form-control" id="Achternaam" value="<?= htmlspecialchars($result->Achternaam ?? $_POST['Achternaam']); ?>" required>
            </div>
            <div class="mb-3">
              <label for="Gebruikersnaam" class="form-label">Gebruikersnaam</label>
              <input name="Gebruikersnaam" type="text" class="form-control" id="Gebruikersnaam" value="<?= htmlspecialchars($result->Gebruikersnaam ?? $_POST['Gebruikersnaam']); ?>" required>
            </div>
            <div class="mb-3">
              <label for="Wachtwoord" class="form-label">Wachtwoord (leeglaten om niet te wijzigen)</label>
              <input name="Wachtwoord" type="password" class="form-control" id="Wachtwoord" value="">
            </div>

            <input type="hidden" name="Id" value="<?= htmlspecialchars($result->Id ?? $_POST['Id']); ?>">

            <div class="d-grid gap-2">
              <button name="submit" value="submit" type="submit" class="btn btn-primary btn-lg">Wijzigen</button>
            </div>
          </form>
        </div>
        <div class="col-3"></div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
