<?php
$host = 'localhost';
$db = 'AuroraDB';
$user = 'root';
$pass = '';

$foutmelding = '';
$success = false;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $naam = $_POST['naam'] ?? '';
        $beschrijving = $_POST['beschrijving'] ?? '';
        $afbeelding = $_POST['afbeelding'] ?? '';
        $datum = $_POST['datum'] ?? '';
        $tijd = $_POST['tijd'] ?? '';
        $maxTickets = $_POST['maxTickets'] ?? '';
        $beschikbaarheid = $_POST['beschikbaarheid'] ?? '';
        $opmerking = $_POST['opmerking'] ?? '';

        if (empty($naam) || empty($beschrijving) || empty($afbeelding) || empty($datum) || empty($tijd) || empty($maxTickets) || empty($beschikbaarheid)) {
            $foutmelding = "Niet alle velden zijn ingevuld.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO Voorstelling 
            (MedewerkerId, Naam, Beschrijving, AfbeeldingUrl, Datum, Tijd, MaxAantalTickets, Beschikbaarheid, Isactief, Opmerking, Datumaangemaakt, Datumgewijzigd) 
            VALUES (1, :naam, :beschrijving, :afbeeldingUrl, :datum, :tijd, :maxTickets, :beschikbaarheid, 1, :opmerking, NOW(), NOW())");

            $stmt->execute([
                ':naam' => $naam,
                ':beschrijving' => $beschrijving,
                ':afbeeldingUrl' => $afbeelding,
                ':datum' => $datum,
                ':tijd' => $tijd,
                ':maxTickets' => $maxTickets,
                ':beschikbaarheid' => $beschikbaarheid,
                ':opmerking' => $opmerking
            ]);

            $success = true;
        }
    }
} catch (PDOException $e) {
    $foutmelding = "Databasefout: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Voorstelling toevoegen</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #111;
            color: #fff;
            font-family: Arial, sans-serif;
            padding: 2rem;
        }

        h1 {
            color: #fff;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-top: 1rem;
        }

        input, textarea, select {
            width: 100%;
            padding: 0.5rem;
            margin-top: 0.5rem;
            border-radius: 4px;
            border: none;
        }

        .foutmelding {
            background-color: #e74c3c;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 5px;
            color: #fff;
        }

        .succesmelding {
            background-color: #2ecc71;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 5px;
            color: #111;
        }

        button {
            background-color: #e74c3c;
            color: #fff;
            padding: 0.7rem 1.5rem;
            margin-top: 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

    <h1>Voorstelling toevoegen</h1>

    <?php if ($foutmelding): ?>
        <div class="foutmelding"><?= htmlspecialchars($foutmelding) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="succesmelding">Voorstelling succesvol toegevoegd! Je wordt zo doorgestuurd...</div>
        <script>
            setTimeout(function() {
                window.location.href = 'Overzicht.php';
            }, 2000);
        </script>
    <?php endif; ?>

    <form method="post">
        <label>Naam</label>
        <input type="text" name="naam" required>

        <label>Beschrijving</label>
        <textarea name="beschrijving" rows="4" required></textarea>

        <label>Afbeelding pad</label>
        <input type="text" name="afbeelding" required>

        <label>Datum</label>
        <input type="date" name="datum" required>

        <label>Tijd</label>
        <input type="time" name="tijd" required>

        <label>Max aantal tickets</label>
        <input type="number" name="maxTickets" required>

        <label>Beschikbaarheid</label>
        <select name="beschikbaarheid" required>
            <option value="">-- Kies --</option>
            <option value="Beschikbaar">Beschikbaar</option>
            <option value="Niet Beschikbaar">Niet Beschikbaar</option>
        </select>

        <label>Opmerking (optioneel)</label>
        <input type="text" name="opmerking">

        <button type="submit">Toevoegen</button>
    </form>

</body>
</html>
