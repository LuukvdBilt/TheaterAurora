<?php

declare(strict_types=1);

class MedewerkerModel
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Haalt alle medewerkers op met gegevens van de gekoppelde gebruiker via JOIN
     * @return array
     * @throws Exception bij database fouten
     */
    public function getAllMedewerkers(): array
    {
        try {
            $sql = "SELECT m.Id, m.Nummer, m.Medewerkersoort, m.Isactief, m.Opmerking, 
                           m.Datumaangemaakt, m.Datumgewijzigd,
                           g.Voornaam, g.Tussenvoegsel, g.Achternaam
                    FROM Medewerker m
                    INNER JOIN Gebruiker g ON m.GebruikerId = g.Id
                    ORDER BY m.Id ASC";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $medewerkers = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $medewerkers;
        } catch (PDOException $e) {
            // Log fout 
            throw new Exception("Fout bij ophalen medewerkers: " . $e->getMessage());
        }
    }
}
