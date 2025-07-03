<?php

class MedewerkersModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // medewerker gegevens ophalen
    public function getAllMedewerkers()
    {
        try {
            $sql = 'SELECT 
                        M.Id, 
                        M.GebruikerId, 
                        M.Nummer, 
                        M.Medewerkersoort, 
                        M.Isactief, 
                        M.Opmerking,
                        G.Id AS GebruikerJoinId  
                    FROM Medewerker AS M
                    INNER JOIN Gebruiker AS G ON M.GebruikerId = G.Id
                    ORDER BY M.Id ASC';

            $this->db->query($sql);
            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log("Fout in getAllMedewerkers (JOIN): " . $e->getMessage());
            return false;
        }
    }

    //medewerker identificeren bij hun id
    public function getMedewerkerById($id)
    {
        try {
            $sql = 'SELECT M.Id, M.GebruikerId, M.Nummer, M.Medewerkersoort, M.Isactief, M.Opmerking
                    FROM Medewerker AS M
                    WHERE M.Id = :id';
            $this->db->query($sql);
            $this->db->bind(':id', $id, PDO::PARAM_INT);
            return $this->db->single();
        } catch (PDOException $e) {
            error_log("Fout in getMedewerkerById: " . $e->getMessage());
            return false;
        }
    }


    // Functie om logs te schrijven
    private function logAction($action, $data)
    {
        $logFile = __DIR__ . '/medewerkers.log'; // Logbestand in dezelfde map als dit PHP-bestand
        $date = date('Y-m-d H:i:s');
        $entry = "[$date] ACTION: $action | DATA: " . json_encode($data) . PHP_EOL;
        file_put_contents($logFile, $entry, FILE_APPEND);
    }

    // gegevens om een medewerker aan te maken
    public function create($data)
    {
        try {
            $sql = "INSERT INTO Medewerker (GebruikerId, Nummer, Medewerkersoort, Isactief, Opmerking, Datumaangemaakt, Datumgewijzigd)
                    VALUES (:gebruikerid, :nummer, :soort, :isactief, :opmerking, NOW(6), NOW(6))";
            $this->db->query($sql);
            $this->db->bind(':gebruikerid', $data['gebruikerid'], PDO::PARAM_INT);
            $this->db->bind(':nummer', $data['nummer'], PDO::PARAM_INT);
            $this->db->bind(':soort', $data['soort'], PDO::PARAM_STR);
            $this->db->bind(':isactief', $data['isactief'], PDO::PARAM_INT);
            $this->db->bind(':opmerking', $data['opmerking'], PDO::PARAM_STR);
            $result = $this->db->execute();

            if ($result) {
                $this->logAction('CREATE', $data);
            }

            return $result;
        } catch (PDOException $e) {
            error_log("Fout in create: " . $e->getMessage());
            return false;
        }
    }

    // Update met logging
    public function update($data)
    {
        try {
            $sql = "UPDATE Medewerker
                    SET GebruikerId = :gebruikerid,
                        Nummer = :nummer,
                        Medewerkersoort = :soort,
                        Isactief = :isactief,
                        Opmerking = :opmerking,
                        Datumgewijzigd = NOW(6)
                    WHERE Id = :id";
            $this->db->query($sql);
            $this->db->bind(':gebruikerid', $data['gebruikerid'], PDO::PARAM_INT);
            $this->db->bind(':nummer', $data['nummer'], PDO::PARAM_INT);
            $this->db->bind(':soort', $data['soort'], PDO::PARAM_STR);
            $this->db->bind(':isactief', $data['isactief'], PDO::PARAM_INT);
            $this->db->bind(':opmerking', $data['opmerking'], PDO::PARAM_STR);
            $this->db->bind(':id', $data['id'], PDO::PARAM_INT);
            $result = $this->db->execute();

            if ($result) {
                $this->logAction('UPDATE', $data);
            }

            return $result;
        } catch (PDOException $e) {
            error_log("Fout in update: " . $e->getMessage());
            return false;
        }
    }

    // Delete met logging
    public function delete($id)
    {
        try {
            // Eerst check of medewerker inactief is
            $sqlCheck = "SELECT Isactief FROM Medewerker WHERE Id = :id";
            $this->db->query($sqlCheck);
            $this->db->bind(':id', $id, PDO::PARAM_INT);
            $medewerker = $this->db->single();

            if ($medewerker && $medewerker->Isactief == 1) {
                return false; // Actieve medewerker mag niet verwijderd worden
            }

            // als de id wel inactief is dan kan je verwijderen
            $sqlDelete = "DELETE FROM Medewerker WHERE Id = :id";
            $this->db->query($sqlDelete);
            $this->db->bind(':id', $id, PDO::PARAM_INT);
            $result = $this->db->execute();

            if ($result) {
                $this->logAction('DELETE', ['Id' => $id]);
            }

            return $result;
        } catch (PDOException $e) {
            error_log("Fout in delete: " . $e->getMessage());
            return false;
        }
    }

   // checken of het id al in gebruik is zodat die niet dubbel gebruikt kan worden
    public function gebruikerIdExists($gebruikerId, $excludeId = null)
    {
        try {
            $sql = 'SELECT COUNT(*) as aantal FROM Medewerker WHERE GebruikerId = :gebruikerid';
            if ($excludeId) {
                $sql .= ' AND Id != :id';
            }
            $this->db->query($sql);
            $this->db->bind(':gebruikerid', $gebruikerId, PDO::PARAM_INT);
            if ($excludeId) {
                $this->db->bind(':id', $excludeId, PDO::PARAM_INT);
            }
            $result = $this->db->single();
            return $result->aantal > 0;
        } catch (PDOException $e) {
            error_log("Fout in gebruikerIdExists: " . $e->getMessage());
            return false;
        }
    }
}
