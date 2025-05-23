<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/db_connect.php';
require_once 'MedewerkerModel.php';

class MedewerkerController
{
    private MedewerkerModel $model;

    public function __construct(PDO $conn)
    {
        $this->model = new MedewerkerModel($conn);
    }

    /**
     * Haalt alle medewerkers op en retourneert JSON response
     */
    public function getMedewerkers(): void
    {
        header('Content-Type: application/json');

        try {
            $medewerkers = $this->model->getAllMedewerkers();

            echo json_encode($medewerkers);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }
}
