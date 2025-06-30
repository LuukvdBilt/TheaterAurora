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
        $sql = 'SELECT M.Id, M.GebruikerId, M.Nummer, M.Medewerkersoort, M.Isactief, M.Opmerking
                FROM Medewerker AS M
                ORDER BY M.Id ASC';
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getMedewerkerById($id)
    {
        $sql = 'SELECT M.Id, M.GebruikerId, M.Nummer, M.Medewerkersoort, M.Isactief, M.Opmerking
                FROM Medewerker AS M
                WHERE M.Id = :id';
        $this->db->query($sql);
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->single();
    }

    public function create($data)
    {
        $sql = "INSERT INTO Medewerker (GebruikerId, Nummer, Medewerkersoort, Isactief, Opmerking, Datumaangemaakt, Datumgewijzigd)
                VALUES (:gebruikerid, :nummer, :soort, :isactief, :opmerking, NOW(6), NOW(6))";
        $this->db->query($sql);
        $this->db->bind(':gebruikerid', $data['gebruikerid'], PDO::PARAM_INT);
        $this->db->bind(':nummer', $data['nummer'], PDO::PARAM_INT);
        $this->db->bind(':soort', $data['soort'], PDO::PARAM_STR);
        $this->db->bind(':isactief', $data['isactief'], PDO::PARAM_INT);
        $this->db->bind(':opmerking', $data['opmerking'], PDO::PARAM_STR);
        return $this->db->execute();
    }

    public function update($data)
    {
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
    }

    public function delete($id)
    {
        $sql = "DELETE FROM Medewerker WHERE Id = :id";
        $this->db->query($sql);
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->execute();
    }
}