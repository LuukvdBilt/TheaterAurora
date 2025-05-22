<?php
$host = 'localhost';
$db = 'AuroraDB'; // vervang dit!
$user = 'root';   // vervang dit!
$pass = '';       // vervang dit!

$dbFout = false;
$voorstellingen = [];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $stmt = $pdo->prepare("SELECT Naam, Beschrijving, AfbeeldingUrl, Datum, Tijd, MaxAantalTickets, Beschikbaarheid, Opmerking FROM Voorstelling WHERE Isactief = 1 ORDER BY Datum ASC");
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

        h1 {
            text-align: center;
            margin-top: 2rem;
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
        }
    </style>
</head>
<body>
    <nav>
    <div class="logo"> <img src="/Images/Theater-logo.png" id="LOGO"></div>
    <div>
      <a href="index.html">Home</a>
      <a href="">Voorstellingen</a>
      <a href="">Contact</a>
      <a href="">Login</a>
    </div>
  </nav>

<?php if ($dbFout): ?>
    <div class="centered-message">
        <h2>Technisch probleem</h2>
        <p>Er is momenteel geen verbinding met de database.<br>Voorstellingen kunnen niet worden weergegeven.</p>
    </div>
<?php else: ?>
    <h1>Overzicht van voorstellingen</h1>
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
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php endif; ?>

</body>
</html>
