<?php

class Medewerkers extends BaseController
{
    private $medewerkersModel;

    public function __construct()
    {
        $this->medewerkersModel = $this->model('MedewerkersModel');
    }

    public function index($message = 'none')
    {
        $result = $this->medewerkersModel->getAllMedewerkers();

        $data = [
            'title' => 'Overzicht Medewerkers',
            'medewerkers' => $result,
            'message' => $message
        ];

        $this->view('medewerkers/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Nieuwe Medewerker',
            'message' => 'none'
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->medewerkersModel->create([
                'gebruikerid' => $_POST['gebruikerid'],
                'nummer' => $_POST['nummer'],
                'soort' => $_POST['soort'],
                'isactief' => isset($_POST['isactief']) ? 1 : 0,
                'opmerking' => $_POST['opmerking'] ?? ''
            ]);
            header('Refresh: 3; url=' . URLROOT . '/medewerkers/index');
            $data['message'] = 'flex';
        }

        $this->view('medewerkers/create', $data);
    }

    public function update($id = null)
    {
        $data = [
            'title' => 'Medewerker Wijzigen',
            'message' => 'none'
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->medewerkersModel->update([
                'id' => $_POST['id'],
                'gebruikerid' => $_POST['gebruikerid'],
                'nummer' => $_POST['nummer'],
                'soort' => $_POST['soort'],
                'isactief' => isset($_POST['isactief']) ? 1 : 0,
                'opmerking' => $_POST['opmerking'] ?? ''
            ]);
            header('Refresh: 3; url=' . URLROOT . '/medewerkers/index');
            $data['message'] = 'flex';
        }

        $data['medewerker'] = $this->medewerkersModel->getMedewerkerById($id);

        $this->view('medewerkers/update', $data);
    }

    public function delete($id)
    {
        $this->medewerkersModel->delete($id);
        $this->index('flex');
        header('Refresh: 3; url=' . URLROOT . '/medewerkers/index');
        exit;
    }
}