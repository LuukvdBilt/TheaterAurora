<?php

class MedewerkersModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllMedewerkers()
    {
        try {
            $sql = 'SELECT M.Id, M.GebruikerId, M.Nummer, M.Medewerkersoort, M.Isactief, M.Opmerking
                    FROM Medewerker AS M
                    ORDER BY M.Id ASC';
            $this->db->query($sql);
            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log("Fout in getAllMedewerkers: " . $e->getMessage());
            return false;
        }
    }

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
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log("Fout in create: " . $e->getMessage());
            return false;
        }
    }

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
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log("Fout in update: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM Medewerker WHERE Id = :id";
            $this->db->query($sql);
            $this->db->bind(':id', $id, PDO::PARAM_INT);
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log("Fout in delete: " . $e->getMessage());
            return false;
        }
    }

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
