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
            'message' => 'none'
        ];

        if ($_SERVER['REQUEST_METHOD'] == "POST")
        {

            $createData = $_POST;
            $createData['isactief'] = isset($_POST['isactief']) ? 1 : 0;


            $result = $this->MedewerkersModel->create($_POST);

            $data['message'] = 'flex';
            
            header('Refresh:3 ; url=' . URLROOT . '/medewerkers/index');

        }        

        $this->view('medewerkers/create', $data);
    }

public function update($Id = NULL)
{
    $data = [
        'title' => 'Wijzig medewerker',
        'message' => 'none'
    ];

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $updateData = $_POST;
        $updateData['id'] = $Id; 
         $updateData['isactief'] = isset($_POST['isactief']) ? 1 : 0;

        $this->MedewerkersModel->update($updateData);

        $data['message'] = 'flex';

        header('Refresh: 3; url=' . URLROOT . '/medewerkers/index');
    }
    
    $data['medewerker'] = $this->MedewerkersModel->getMedewerkerById($Id);        

    $this->view('medewerkers/update', $data);        
}
}