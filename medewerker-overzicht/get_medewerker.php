<?php
require_once "../config/db_connect.php";

try {
    $stmt = $pdo->query("
        SELECT 
            m.Id, m.Nummer, m.Medewerkersoort, m.Isactief, m.Opmerking, m.Datumaangemaakt, m.Datumgewijzigd,
            g.Voornaam, g.Tussenvoegsel, g.Achternaam, g.Gebruikersnaam
        FROM Medewerker m
        INNER JOIN Gebruiker g ON m.GebruikerId = g.Id
        ORDER BY m.Id ASC
    ");

    $medewerkers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($medewerkers);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Fout bij ophalen medewerkers: ' . $e->getMessage()]);
}
