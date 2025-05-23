<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.8/build/css/intlTelInput.css">
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.8/build/js/intlTelInput.min.js"></script>
    <link rel="stylesheet" href="style.css">

    <title>Dashboard</title>
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
                            <a class="nav-link" href="../registratie/dashboard.php">
                                <i class="fa fa-home"></i> Dashboard
                            </a>
                        </li>

                        <div class="menu-header">Overzichten</div>
                            <li class="nav-item">
                                <a class="nav-link" href="../medewerker-overzicht/MedewerkersOV.php">
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
                                <a class="nav-link" href="../Voorstellingen/Overzicht.php">
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
</body>
</html>