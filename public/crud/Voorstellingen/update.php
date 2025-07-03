<?php
// Database instellingen
$host = 'localhost';
$db = 'AuroraDB';
$user = 'root';
$pass = '';

$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);

if (!isset($_GET['id'])) {
    header("Location: Overzicht.php");
    exit;
}

$id = $_GET['id'];
$melding = "";

// Huidige gegevens ophalen
$stmt = $pdo->prepare("SELECT * FROM Voorstelling WHERE Id = ?");
$stmt->execute([$id]);
$voorstelling = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$voorstelling) {
    header("Location: Overzicht.php");
    exit;
}

// Als formulier is ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = $_POST['naam'];
    $beschrijving = $_POST['beschrijving'];
    $afbeeldingUrl = $_POST['afbeeldingUrl'];
    $datum = $_POST['datum'];
    $tijd = $_POST['tijd'];
    $maxTickets = $_POST['maxTickets'];
    $beschikbaarheid = $_POST['beschikbaarheid'];
    $opmerking = $_POST['opmerking'];

    // Check of er lege velden zijn
    if (empty($naam) || empty($beschrijving) || empty($afbeeldingUrl) || empty($datum) || empty($tijd) || empty($maxTickets) || empty($beschikbaarheid)) {
        $melding = "Vul alle verplichte velden in.";
    } else {
        // Update uitvoeren
        $stmt = $pdo->prepare("UPDATE Voorstelling SET Naam = ?, Beschrijving = ?, AfbeeldingUrl = ?, Datum = ?, Tijd = ?, MaxAantalTickets = ?, Beschikbaarheid = ?, Opmerking = ? WHERE Id = ?");
        $stmt->execute([$naam, $beschrijving, $afbeeldingUrl, $datum, $tijd, $maxTickets, $beschikbaarheid, $opmerking, $id]);

        $melding = "Voorstelling succesvol bijgewerkt. Je wordt teruggestuurd...";
        header("refresh:2;url=Overzicht.php");
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Voorstelling bewerken</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #111;
            color: #fff;
            font-family: Arial, sans-serif;
            padding: 2rem;
        }
        form {
            background-color: #222;
            padding: 2rem;
            max-width: 500px;
            margin: 0 auto;
            border: 1px solid #fff;
            border-radius: 10px;
        }
        input, textarea, select {
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
            color:rgb(4, 188, 16);
            margin-top: 1rem;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>

<h1>Voorstelling bewerken</h1>

<form method="post">
    <input type="text" name="naam" placeholder="Naam" value="<?= htmlspecialchars($voorstelling['Naam']) ?>" required>
    <textarea name="beschrijving" placeholder="Beschrijving" required><?= htmlspecialchars($voorstelling['Beschrijving']) ?></textarea>
    <input type="text" name="afbeeldingUrl" placeholder="Afbeelding URL" value="<?= htmlspecialchars($voorstelling['AfbeeldingUrl']) ?>" required>
    <input type="date" name="datum" value="<?= htmlspecialchars($voorstelling['Datum']) ?>" required>
    <input type="time" name="tijd" value="<?= htmlspecialchars($voorstelling['Tijd']) ?>" required>
    <input type="number" name="maxTickets" placeholder="Maximaal aantal tickets" value="<?= htmlspecialchars($voorstelling['MaxAantalTickets']) ?>" required>
    <select name="beschikbaarheid" required>
        <option value="Beschikbaar" <?= $voorstelling['Beschikbaarheid'] === 'Beschikbaar' ? 'selected' : '' ?>>Beschikbaar</option>
        <option value="Niet beschikbaar" <?= $voorstelling['Beschikbaarheid'] === 'Niet beschikbaar' ? 'selected' : '' ?>>Niet beschikbaar</option>
    </select>
    <input type="text" name="opmerking" placeholder="Opmerking (optioneel)" value="<?= htmlspecialchars($voorstelling['Opmerking']) ?>">

    <button type="submit">Bijwerken</button>
</form>

<?php if ($melding): ?>
    <p class="melding"><?= $melding ?></p>
<?php endif; ?>

</body>
</html>
