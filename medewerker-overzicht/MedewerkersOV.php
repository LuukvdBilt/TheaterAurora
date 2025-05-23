<?php
// Database connection
require_once "../config/db_connect.php";
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medewerker Overzicht</title>
    <script defer src="medewerker.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.8/build/css/intlTelInput.css">
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.8/build/js/intlTelInput.min.js"></script>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <i class="fa fa-user-circle fa-3x"></i>
                      
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="../Dashboard/index.php">
                                <i class="fa fa-home"></i> Dashboard
                            </a>
                        </li>

                        <div class="menu-header">Overzichten</div>
                            <li class="nav-item">
                                <a class="nav-link active" href="../medewerker-overzicht/MedewerkersOV.php">
                                    <i class="fa fa-users"></i> Medewerker-overzicht
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="">
                                    <i class="fa fa-address-card"></i> overzicht 
                                </a>
                            </li>
                       
                            <li class="nav-item">
                                <a class="nav-link" href="">
                                    <i class="fa fa-user-circle"></i> overzicht
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="fa fa-line-chart"></i>Voorstellingen
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="fa fa-calendar-check-o"></i> Tickets
                                </a>
                            </li>

                        <div class="menu-header">Systeem</div>
                        <li class="nav-item">
                            <a class="nav-link" href="../HomePagina/index.html">
                                <i class=" fa fa-arrow-left"></i> Homepagina
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../registratie/logout.php">
                                <i class="fa fa-sign-out"></i> Uitloggen
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="card dashboard-card">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="fa fa-users"></i> Medewerker Overzicht</h5>
                    </div>
                    <div class="card-body">
                        <p id="message"></p>
                        
                        <!-- Button om nieuwe medewerker toe te voegen -->
                       
                        <div class="mb-3">
                            <button onclick="window.location.href='add_medewerker.php';" class="btn btn-secondary">
                                Nieuwe Medewerker Toevoegen
                            </button>
                        </div>
                      <div id="feedback"></div>
                        <table id="medewerkerTable" class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nummer</th>
                                    <th>Soort</th>
                                    <th>Status</th>
                                    <th>Opmerking</th>
                                    <th>Aangemaakt</th>
                                    <th>Gewijzigd</th>
                                    <th>Acties</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>


    <!-- Modal voor wachtwoordverificatie -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Bevestig Verwijdering</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Vul je wachtwoord in om deze medewerker te verwijderen:</p>
                <input type="password" id="wachtwoord" class="form-control" placeholder="Wachtwoord" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                <button type="button" id="confirmDeleteButton" class="btn btn-danger">Verwijder Medewerker</button>
            </div>
        </div>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        // Voeg deze JavaScript functie toe om de modal te openen
        function openDeleteModal(id) {
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
            document.getElementById('confirmDeleteButton').onclick = () => confirmDelete(id);
        }

        // De confirmDelete functie die je al hebt
        function confirmDelete(id) {
            const wachtwoord = document.getElementById('wachtwoord').value;

            // Controleer of het wachtwoord leeg is
            if (!wachtwoord) {
                alert("Vul je wachtwoord in.");
                return;
            }

            // Verstuur het verzoek naar de server voor wachtwoordverificatie en verwijdering
            fetch("delete_medewerker.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ id: id, wachtwoord: wachtwoord })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Sluit de modal en geef een succesbericht
                    alert(data.message);
                    location.reload(); // Herlaad de pagina om de verwijderde medewerker te verwijderen
                } else {
                    alert(data.message); // Toon een foutbericht als er iets mis is
                }
            })
            .catch(error => {
                console.error("Fout bij het verwijderen:", error);
                alert("Er is een fout opgetreden.");
            });
        }
    </script>
    <script defer src="medewerker.js"></script>
</body>
</html>
