<?php
// Database instellingen
$host = 'localhost';
$db = 'AuroraDB';
$user = 'root';
$pass = '';

$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);

// Check of er een id is meegegeven
if (!isset($_GET['id'])) {
    header("Location: Overzicht.php");
    exit;
}

$id = $_GET['id'];
$melding = "";
$correcteCode = "AURORA123"; // Pas deze code zelf aan naar iets geheims!

// Ophalen van de voorstelling (optioneel, voor tonen van info)
$stmt = $pdo->prepare("SELECT Naam FROM Voorstelling WHERE Id = ?");
$stmt->execute([$id]);
$voorstelling = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$voorstelling) {
    header("Location: Overzicht.php");
    exit;
}

// Als formulier is ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ingevoerdeCode = $_POST['bevestigingscode'];

    if ($ingevoerdeCode === $correcteCode) {
        // Voorstelling verwijderen
        $stmt = $pdo->prepare("DELETE FROM Voorstelling WHERE Id = ?");
        $stmt->execute([$id]);
        $melding = "Voorstelling succesvol verwijderd. Je wordt teruggestuurd...";
        header("refresh:2;url=Overzicht.php");
    } else {
        $melding = "Foutieve bevestigingscode. Verwijderen geannuleerd.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Voorstelling verwijderen</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #111;
            color: #fff;
            font-family: Arial, sans-serif;
            padding: 2rem;
            text-align: center;
        }
        form {
            background-color: #222;
            padding: 2rem;
            margin: 0 auto;
            max-width: 400px;
            border: 1px solid #fff;
            border-radius: 10px;
        }
        input {
            width: 100%;
            padding: 0.5rem;
            margin-top: 1rem;
            background-color: #333;
            color: #fff;
            border: 1px solid #555;
            border-radius: 5px;
        }
        button {
            background-color: #e74c3c;
            color: #fff;
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 5px;
            margin-top: 1rem;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background-color: #c0392b;
        }
        .melding {
            margin-top: 1rem;
            font-weight: bold;
        }
        a {
            display: block;
            color: #fff;
            margin-top: 1.5rem;
        }
    </style>
</head>
<body>

<h1>Verwijderen voorstelling: <br> <?= htmlspecialchars($voorstelling['Naam']) ?></h1>

<p>Vul de geheime bevestigingscode in om deze voorstelling te verwijderen.</p>

<form method="post">
    <input type="password" name="bevestigingscode" placeholder="Bevestigingscode" required>
    <button type="submit">Verwijderen</button>
</form>

<?php if ($melding): ?>
    <p class="melding"><?= $melding ?></p>
<?php endif; ?>

<a href="Overzicht.php">Annuleren en terug</a>

</body>
</html>
