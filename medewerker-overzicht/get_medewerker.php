<?php
// Verbind met de database
require_once "../config/db_connect.php";

try {
    // Haal medewerkers op, inclusief gebruikersgegevens
    $stmt = $pdo->query("
        SELECT 
            m.Id, m.Nummer, m.Medewerkersoort, m.Isactief, m.Opmerking, 
            m.Datumaangemaakt, m.Datumgewijzigd,
            g.Voornaam, g.Tussenvoegsel, g.Achternaam, g.Gebruikersnaam
        FROM Medewerker m
        INNER JOIN Gebruiker g ON m.GebruikerId = g.Id
        ORDER BY m.Id ASC
    ");

    // Zet resultaat om naar associatieve array
    $medewerkers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Zet Content-Type header en verstuur JSON-response
    header('Content-Type: application/json');
    echo json_encode($medewerkers);

} catch (Exception $e) {
    // Foutafhandeling met melding
    http_response_code(500);
    echo json_encode(['error' => 'Fout bij ophalen medewerkers: ' . $e->getMessage()]);
}
