<?php

class medewerkers extends BaseController
{
    // Eigenschap om het model te bewaren
    private $MedewerkersModel;

    public function __construct()
    {
        $this->MedewerkersModel = $this->model('MedewerkersModel');
    }

    // Standaard methode, toont alle medewerkers
    public function index($message = 'none')
    {
        // Haal alle medewerkers op uit het model
        $result = $this->MedewerkersModel->getAllmedewerkers();
        
        // Zet data klaar om door te geven aan de view
        $data = [
            'title' => 'Medewerkers',
            'medewerkers' => $result,
            'message' => $message
        ];

        // Toon de view met de opgehaalde data
        $this->view('medewerkers/index', $data);
    }

    // Methode om een medewerker te verwijderen
    public function delete($Id)
    {
        // Verwijder de medewerker met de gegeven Id
        $this->MedewerkersModel->delete($Id);
        
        header('Refresh:3 ; url=' . URLROOT . '/medewerkers/index');

        // Toon de index pagina met een bericht
        $this->index('flex');
    }

    // Methode om een nieuwe medewerker toe te voegen
    public function create()
    {
        $data = [
            'title' => "Voeg een nieuwe medewerker toe",
            'message' => 'none',
            'error' => ''
        ];

        // Check of het formulier is verzonden 
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $createData = $_POST;

            // Bepaal of de medewerker actief is
            $createData['isactief'] = isset($_POST['isactief']) ? 1 : 0;

            // Check of gebruikerId al bestaat in de database
            if ($this->MedewerkersModel->gebruikerIdExists($createData['gebruikerid'])) {
                // Foutmelding als het gebruikerId al in gebruik is
                $data['error'] = "Het gebruiker Id is al in gebruik, voer een nieuwe in.";
            } else {
                // Maak nieuwe medewerker aan in het model
                $this->MedewerkersModel->create($createData);
                // Zet bericht dat alles gelukt is
                $data['message'] = 'flex';
                header('Refresh:3 ; url=' . URLROOT . '/medewerkers/index');
            }
        }

        // Toon de create view met de data (eventueel met error)
        $this->view('medewerkers/create', $data);
    }

    // Methode om een bestaande medewerker te wijzigen
    public function update($Id = NULL)
    {
        // Voorbereiden van data voor de view
        $data = [
            'title' => 'Wijzig medewerker',
            'message' => 'none',
            'error' => ''
        ];

        // Check of formulier is verzonden
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $updateData = $_POST;
            $updateData['id'] = $Id;
            $updateData['isactief'] = isset($_POST['isactief']) ? 1 : 0;

            // Controleer of het gebruikerId al bestaat (uitgezonderd het huidige record)
            if ($this->MedewerkersModel->gebruikerIdExists($updateData['gebruikerid'], $Id)) {
                // Foutmelding indien gebruikerId al in gebruik is
                $data['error'] = "Het gebruiker Id is al in gebruik, voer een nieuwe in.";
            } else {
                // Update de medewerker in het model
                $this->MedewerkersModel->update($updateData);
                $data['message'] = 'flex';
                header('Refresh:3 ; url=' . URLROOT . '/medewerkers/index');
            }
        }

        // Haal de medewerker op die aangepast wordt
        $data['medewerker'] = $this->MedewerkersModel->getMedewerkerById($Id);
        $this->view('medewerkers/update', $data);
    }
}
