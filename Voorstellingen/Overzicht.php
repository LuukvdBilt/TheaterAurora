<?php
// Database instellingen
$host = 'localhost';
$db = 'AuroraDB'; // vervang dit!
$user = 'root';   // vervang dit!
$pass = '';       // vervang dit!

$dbFout = false; // Geeft aan of er een databasefout is opgetreden
$voorstellingen = []; // Array voor de opgehaalde voorstellingen

try {
    // Maak verbinding met de database via PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    // Bereid de SQL-query voor om actieve voorstellingen op te halen
    $stmt = $pdo->prepare("SELECT Naam, Beschrijving, AfbeeldingUrl, Datum, Tijd, MaxAantalTickets, Beschikbaarheid, Opmerking FROM Voorstelling WHERE Isactief = 1 ORDER BY Datum ASC");
    // Voer de query uit
    $stmt->execute();
    // Haal alle resultaten op als associatieve array
    $voorstellingen = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Als er een fout optreedt, zet $dbFout op true
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
        /* Stijl voor de hele pagina */
        body {
            background-color: #111;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Titel centreren */
        h1 {
            text-align: center;
            margin-top: 2rem;
        }

        /* Grid-container voor de kaarten */
        .container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            padding: 2rem;
        }

        /* Stijl voor elke voorstelling-kaart */
        .kaart {
            background-color: #222;
            border: 1px solid #fff;
            padding: 1rem;
            border-radius: 10px;
            text-align: center;
        }

        /* Afbeelding in de kaart */
        .kaart img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        /* Titel van de voorstelling */
        .kaart h3 {
            margin: 0.5rem 0;
        }

        /* Paragraaf in de kaart */
        .kaart p {
            font-size: 0.9rem;
            margin: 0.4rem 0;
        }

        /* Bericht centreren bij foutmelding */
        .centered-message {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            flex-direction: column;
            padding: 2rem;
        }

        /* Beschikbaarheid label */
        .beschikbaarheid {
            font-weight: bold;
            padding: 0.3rem 0.6rem;
            border-radius: 5px;
            display: inline-block;
        }

        /* Groene kleur als beschikbaar */
        .beschikbaar {
            background-color: #2ecc71;
            color: #111;
        }

        /* Rode kleur als niet beschikbaar */
        .niet-beschikbaar {
            background-color: #e74c3c;
            color: #fff;
        }

        /* Responsief: 2 kolommen bij kleinere schermen */
        @media (max-width: 1000px) {
            .container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Responsief: 1 kolom bij mobiele schermen */
        @media (max-width: 600px) {
            .container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigatiebalk bovenaan de pagina -->
    <nav>
        <div class="logo">
            <img src="/Images/Theater-logo.png" id="LOGO">
        </div>
        <div>
            <a href="../HomePagina/index.html">Home</a>
            <a href="../Voorstellingen/Overzicht.php">Voorstellingen</a>
            <a href="#">Contact</a>
            <a href="../Dashboard/index.php">Dashboard</a>
            <a href="#">Login</a>
        </div>
    </nav>

<?php if ($dbFout): ?>
    <!-- Toon foutmelding als database niet bereikbaar is -->
    <div class="centered-message">
        <h2>Technisch probleem</h2>
        <p>Er is momenteel geen verbinding met de database.<br>Voorstellingen kunnen niet worden weergegeven.</p>
    </div>
<?php else: ?>
    <!-- Toon overzicht van voorstellingen -->
    <h1>Overzicht van voorstellingen</h1>
    <div class="container">
        <?php if (empty($voorstellingen)): ?>
            <!-- Als er geen voorstellingen zijn -->
            <div class="kaart">
                <h3>Geen voorstellingen beschikbaar</h3>
                <p>Er zijn op dit moment geen geplande voorstellingen.</p>
            </div>
        <?php else: ?>
            <!-- Loop door alle voorstellingen heen -->
            <?php foreach ($voorstellingen as $voorstelling): ?>
                <?php
                    // Bepaal CSS-klasse op basis van beschikbaarheid
                    $beschikbaarheid = strtolower($voorstelling['Beschikbaarheid']);
                    $beschikbaarClass = $beschikbaarheid === 'beschikbaar' ? 'beschikbaar' : 'niet-beschikbaar';
                ?>
                <div class="kaart">
                    <!-- Afbeelding van de voorstelling -->
                    <img src="<?= htmlspecialchars($voorstelling['AfbeeldingUrl']) ?>" alt="Afbeelding voorstelling">
                    <!-- Naam van de voorstelling -->
                    <h3><?= htmlspecialchars($voorstelling['Naam']) ?></h3>
                    <!-- Datum en tijd van de voorstelling -->
                    <p><strong><?= date('d-m-Y', strtotime($voorstelling['Datum'])) ?> om <?= date('H:i', strtotime($voorstelling['Tijd'])) ?></strong></p>
                    <!-- Beschrijving van de voorstelling -->
                    <p><?= nl2br(htmlspecialchars($voorstelling['Beschrijving'])) ?></p>
                    <!-- Maximaal aantal tickets -->
                    <p><strong>Tickets:</strong> <?= htmlspecialchars($voorstelling['MaxAantalTickets']) ?></p>
                    <!-- Beschikbaarheid met kleur -->
                    <p>
                        <strong>Beschikbaarheid:</strong>
                        <span class="beschikbaarheid <?= $beschikbaarClass ?>">
                            <?= htmlspecialchars($voorstelling['Beschikbaarheid']) ?>
                        </span>
                    </p>
                    <!-- Eventuele opmerking tonen -->
                    <?php if (!empty($voorstelling['Opmerking'])): ?>
                        <p><em><?= htmlspecialchars($voorstelling['Opmerking']) ?></em></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php endif; ?>

</body>
</html>
