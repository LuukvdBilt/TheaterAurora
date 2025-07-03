<?php

class medewerkers extends BaseController
{
    private $MedewerkersModel;

    public function __construct()
    {
        $this->MedewerkersModel = $this->model('MedewerkersModel');
    }

    public function index($message = 'none')
    {
        $result = $this->MedewerkersModel->getAllmedewerkers();
        
        $data = [
            'title' => 'Medewerkers',
            'medewerkers' => $result,
            'message' => $message
        ];

        $this->view('medewerkers/index', $data);
    }

    public function delete($Id)
    {
        $this->MedewerkersModel->delete($Id);
        
        header('Refresh:3 ; url=' . URLROOT . '/medewerkers/index');

        $this->index('flex');
    }

    public function create()
{
    $data = [
        'title' => "Voeg een nieuwe medewerker toe",
        'message' => 'none',
        'error' => ''
    ];

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $createData = $_POST;
        $createData['isactief'] = isset($_POST['isactief']) ? 1 : 0;

        if ($this->MedewerkersModel->gebruikerIdExists($createData['gebruikerid'])) {
            $data['error'] = "Het gebruiker Id is al in gebruik, voer een nieuwe in.";
        } else {
            $this->MedewerkersModel->create($createData);
            $data['message'] = 'flex';
            header('Refresh:3 ; url=' . URLROOT . '/medewerkers/index');
        }
    }

    $this->view('medewerkers/create', $data);
}


public function update($Id = NULL)
{
    $data = [
        'title' => 'Wijzig medewerker',
        'message' => 'none',
        'error' => ''
    ];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $updateData = $_POST;
        $updateData['id'] = $Id;
        $updateData['isactief'] = isset($_POST['isactief']) ? 1 : 0;

        // Check of gebruikerid al bestaat, behalve bij eigen record
        if ($this->MedewerkersModel->gebruikerIdExists($updateData['gebruikerid'], $Id)) {
            $data['error'] = "Het gebruiker Id is al in gebruik, voer een nieuwe in.";
        } else {
            $this->MedewerkersModel->update($updateData);
            $data['message'] = 'flex';
            header('Refresh:3 ; url=' . URLROOT . '/medewerkers/index');
        }
    }

    $data['medewerker'] = $this->MedewerkersModel->getMedewerkerById($Id);
    $this->view('medewerkers/update', $data);
}

}