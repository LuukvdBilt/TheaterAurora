<?php
// Stap 1: check of ID is meegegeven
if (!isset($_GET['Id'])) {
    echo "Geen ID opgegeven.";
    exit;
}

$id = $_GET['Id'];

// Stap 2: Als gebruiker nog niet bevestigd heeft
if (!isset($_POST['bevestigen'])) {
?>
<!doctype html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Bevestig verwijdering</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <div class="alert alert-warning text-center">
    <h4>Weet je zeker dat je deze gebruiker wilt verwijderen?</h4>
    <form method="post">
      <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
      <button type="submit" name="bevestigen" class="btn btn-danger">Ja, verwijder</button>
      <a href="accountOverzicht.php" class="btn btn-secondary">Annuleren</a>
    </form>
  </div>
</div>
</body>
</html>
<?php
exit;
}

// Stap 3: Verwijder na bevestiging
require_once('../DB/config.php');

try {
    $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "DELETE FROM Gebruiker WHERE Id = :id";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
    $statement->execute();

    // Succesmelding
    $success = true;
} catch (PDOException $e) {
    $error = "Fout bij verwijderen: " . $e->getMessage();
}
?>

<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8">
  <title>Verwijder gebruiker</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <meta http-equiv="refresh" content="3;url=accountOverzicht.php">
</head>
<body>
  <div class="container mt-3">
    <?php if (isset($success)): ?>
      <div class="alert alert-success text-center">
        De gebruiker is succesvol verwijderd. Je wordt doorgestuurd...
      </div>
    <?php else: ?>
      <div class="alert alert-danger text-center">
        <?= $error ?>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>

