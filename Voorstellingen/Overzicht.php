<?php
// Database instellingen
$host = 'localhost';
$db = 'AuroraDB';
$user = 'root';
$pass = '';

$dbFout = false;
$voorstellingen = [];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $stmt = $pdo->prepare("SELECT Id, Naam, Beschrijving, AfbeeldingUrl, Datum, Tijd, MaxAantalTickets, Beschikbaarheid, Opmerking FROM Voorstelling WHERE Isactief = 1 ORDER BY Datum ASC");
    $stmt->execute();
    $voorstellingen = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $dbFout = true;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Voorstellingen</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #111;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #800000;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin-left: 1rem;
            font-weight: bold;
        }
        .logo img {
            height: 40px;
        }
        h1 {
            margin: 0;
        }
        .title-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2rem;
            padding-bottom: 0;
        }
        .toevoegen-button {
            background-color: #e74c3c;
            color: #fff;
            padding: 0.6rem 1rem;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            margin: 0.2rem;
            display: inline-block;
        }
        .toevoegen-button:hover {
            background-color: #c0392b;
        }
        .container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            padding: 2rem;
        }
        .kaart {
            background-color: #222;
            border: 1px solid #fff;
            padding: 1rem;
            border-radius: 10px;
            text-align: center;
        }
        .kaart img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        .kaart h3 {
            margin: 0.5rem 0;
        }
        .kaart p {
            font-size: 0.9rem;
            margin: 0.4rem 0;
        }
        .centered-message {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            flex-direction: column;
            padding: 2rem;
        }
        .beschikbaarheid {
            font-weight: bold;
            padding: 0.3rem 0.6rem;
            border-radius: 5px;
            display: inline-block;
        }
        .beschikbaar {
            background-color: #2ecc71;
            color: #111;
        }
        .niet-beschikbaar {
            background-color: #e74c3c;
            color: #fff;
        }
        @media (max-width: 1000px) {
            .container {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 600px) {
            .container {
                grid-template-columns: 1fr;
            }
            .title-row {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
<nav>
    <div class="logo"><img src="/Images/Theater-logo.png" id="LOGO"></div>
    <div>
        <a href="../HomePagina/index.html">Home</a>
        <a href="../Voorstellingen/Overzicht.php">Voorstellingen</a>
        <a href="#">Contact</a>
        <a href="../Dashboard/index.php">Dashboard</a>
        <a href="../Tickets/tickets.html">Tickets</a>
        <a href="#">Login</a>
        <a href="#">Uitloggen</a>
    </div>
</nav>

<?php if ($dbFout): ?>
    <div class="centered-message">
        <h2>Er zijn momenteel geen voorstellingen beschikbaar</h2>
    </div>
<?php else: ?>
    <div class="title-row">
        <h1>Overzicht van voorstellingen</h1>
        <a href="Toevoegen.php" class="toevoegen-button">+ Voorstelling toevoegen</a>
    </div>
    <div class="container">
        <?php if (empty($voorstellingen)): ?>
            <div class="kaart">
                <h3>Geen voorstellingen beschikbaar</h3>
                <p>Er zijn op dit moment geen geplande voorstellingen.</p>
            </div>
        <?php else: ?>
            <?php foreach ($voorstellingen as $voorstelling): ?>
                <?php
                    $beschikbaarheid = strtolower($voorstelling['Beschikbaarheid']);
                    $beschikbaarClass = $beschikbaarheid === 'beschikbaar' ? 'beschikbaar' : 'niet-beschikbaar';
                ?>
                <div class="kaart">
                    <img src="<?= htmlspecialchars($voorstelling['AfbeeldingUrl']) ?>" alt="Afbeelding voorstelling">
                    <h3><?= htmlspecialchars($voorstelling['Naam']) ?></h3>
                    <p><strong><?= date('d-m-Y', strtotime($voorstelling['Datum'])) ?> om <?= date('H:i', strtotime($voorstelling['Tijd'])) ?></strong></p>
                    <p><?= nl2br(htmlspecialchars($voorstelling['Beschrijving'])) ?></p>
                    <p><strong>Tickets:</strong> <?= htmlspecialchars($voorstelling['MaxAantalTickets']) ?></p>
                    <p>
                        <strong>Beschikbaarheid:</strong>
                        <span class="beschikbaarheid <?= $beschikbaarClass ?>">
                            <?= htmlspecialchars($voorstelling['Beschikbaarheid']) ?>
                        </span>
                    </p>
                    <?php if (!empty($voorstelling['Opmerking'])): ?>
                        <p><em><?= htmlspecialchars($voorstelling['Opmerking']) ?></em></p>
                    <?php endif; ?>

                    <!-- Bewerken en Verwijderen knoppen -->
                    <a href="Update.php?id=<?= $voorstelling['Id'] ?>" class="toevoegen-button" style="background-color:#3498db;">Bewerken</a>
                    <a href="Delete.php?id=<?= $voorstelling['Id'] ?>" class="toevoegen-button" style="background-color:#e74c3c;" onclick="return confirm('Weet je zeker dat je deze voorstelling wilt verwijderen?');">Verwijderen</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php endif; ?>
</body>
</html>
