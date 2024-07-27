<?php
session_start();

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdventureHub - Dashboard</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="images/logo.png" type="image/png">
    <style>
        body {
            font-family: "Montserrat", sans-serif;
            background-color: #f0f0f0;
        }

        .w3-main {
            margin-left: 300px;
            margin-top: 43px;
        }

        .form-container {
            background-color: #fff;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .w3-bar-item img {
            border-radius: 50%;
        }

        .w3-sidebar .w3-bar-item {
            padding: 16px;
        }

        .w3-table th,
        .w3-table td {
            padding: 12px;
        }

        .error-message {
            color: red;
            font-size: 0.75em;
        }
    </style>
</head>

<body>

    <!-- Top container -->
    <div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
        <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey"
            onclick="toggleSidebar();">
            <i class="fa fa-bars"></i> Menu
        </button>
        <span class="w3-bar-item w3-right">
            <img src="image/logo white.png" alt="Logo" width="40">
        </span>
    </div>

    <!-- Sidebar/menu -->
    <nav class="w3-sidebar w3-collapse w3-white w3-animate-left" id="mySidebar" style="z-index:3;width:300px;">
        <div class="w3-container w3-row">
            <div class="w3-col s4">
                <img src="image/Kyoto.jpg" class="w3-circle" style="width:46px">
            </div>
            <div class="w3-col s8 w3-bar">
                <span>Bienvenue, <strong>Admin</strong></span><br>
                <a href="#" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i></a>
                <a href="#" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
                <a href="#" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
            </div>
        </div>
        <hr>
        <div class="w3-container">
            <h5>Dashboard</h5>
        </div>
        <div class="w3-bar-block">
            <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black"
                onclick="toggleSidebar();" title="close menu">
                <i class="fa fa-remove fa-fw"></i> Close Menu
            </a>
            <a href="http://localhost/gestion_vote/Back/controller/profilAdmin.php"
                class="w3-bar-item w3-button w3-padding">
                <i class="fa fa-user fa-fw"></i> Profil
            </a>
            <a href="http://localhost/gestion_vote/Back/view/ReadUsers.php" class="w3-bar-item w3-button w3-blue">
                <i class="fa fa-eye fa-fw"></i> Voir les Utilisateurs
            </a>
            <a href="http://localhost/gestion_vote/Back/view/user_choice.html" class="w3-bar-item w3-button w3-padding">
                <i class="fa fa-envelope fa-fw"></i> Contacter un Utilisateur
            </a>
            <a href="http://localhost/gestion_vote/Back/view/Create_election.php"
                class="w3-bar-item w3-button w3-padding">
                <i class="fa fa-diamond fa-fw"></i> Create election
            </a>
        </div>
    </nav>

    <!-- Overlay effect when opening sidebar on small screens -->
    <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="toggleSidebar();" style="cursor:pointer"
        title="close side menu" id="myOverlay"></div>

    <!-- Page content -->
    <div class="w3-main">

        <!-- Header -->
        <header class="w3-container" style="padding-top:22px">
            <h5><b><i class="fa fa-dashboard"></i> Dashboard</b></h5>
        </header>

        <!-- User and Agency Lists -->
        <div class="w3-container form-container">
            <?php
            
            require_once '../config.php';
            require_once '../model/User.php';
            require_once '../controller/UsersC.php';
            
            $electorController = new electorC();
            $electors = $electorController->getElector();

            if ($electors) {
                echo "<h2>Liste des electeurs :</h2>";
                echo "<table class='w3-table w3-striped'>";
                echo "<tr>
                <th>ID</th>
                <th>Username</th>
                <th>Full_name</th>
                <th>Email</th>
                <th>Date de naissance</th>
                <th>Adresse</th>
                <th>Actions</th>
                </tr>";
                foreach ($electors as $elector) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($elector["id_elector"]) . "</td>";
                    echo "<td>" . htmlspecialchars($elector["username"]) . "</td>";
                    echo "<td>" . htmlspecialchars($elector["full_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($elector["email"]) . "</td>";
                    echo "<td>" . htmlspecialchars($elector["dob"]) . "</td>";
                    echo "<td>" . htmlspecialchars($elector["adresse"]) . "</td>";
                    echo "<td>
            <form action='user_choice.php' method='POST'>
                <input type='hidden' name='recipientType' value='elector'>
                <input type='hidden' name='userId' value='" . htmlspecialchars($elector["id_elector"]) . "'>
                <button type='submit'>Contacter</button>
            </form>
        </td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Aucun utilisateur trouvé.</p>";
            }
            ?>

            <?php
            require_once '../config.php';
            require_once '../model/User.php';
            require_once '../controller/UsersC.php';
            $candidatController = new CandidatC();
            $candidate = $candidatController->getCandidat();

            if ($candidate) {
                echo "<h2>Liste des candidats :</h2>";
                echo "<table class='w3-table w3-striped'>";
                echo "<tr>
                <th>ID</th>
                <th>Username</th>
                <th>Full_name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Biography</th>
                <th>Program</th>
                <th>Political_party</th>
                <th>Image</th>
                <th>Actions</th>
                </tr>";
                foreach ($candidate as $candidat) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($candidat["id_candidat"]) . "</td>";
                    echo "<td>" . htmlspecialchars($candidat["username"]) . "</td>";
                    echo "<td>" . htmlspecialchars($candidat["full_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($candidat["email"]) . "</td>";
                    echo "<td>" . htmlspecialchars($candidat["adresse"]) . "</td>";
                    echo "<td>" . htmlspecialchars($candidat["biography"]) . "</td>";
                    echo "<td>" . htmlspecialchars($candidat["program"]) . "</td>";
                    echo "<td>" . htmlspecialchars($candidat["political_party"]) . "</td>";
                    echo "<td><img src='images/" . htmlspecialchars($candidat["image"]) . "' class='w3-circle' style='width:46px'></td>";
                    echo "<td>
            <form action='user_choice.php' method='POST'>
                <input type='hidden' name='recipientType' value='candidat'>
                <input type='hidden' name='userId' value='" . htmlspecialchars($candidat["id_candidat"]) . "'>
                <button type='submit'>Contacter</button>
            </form>
        </td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Aucun candidat trouvé.</p>";
            }
            ?>
            <?php
            require_once '../config.php';
            require_once '../model/User.php';
            require_once '../controller/UsersC.php';

            $candidatController = new ElectionC();
            $elections = $candidatController->getElection();

            if ($elections) {
                echo "<h2>Liste des élections :</h2>";
                echo "<table class='w3-table w3-striped'>";
                echo "<tr>
        <th>ID</th>
        <th>Title</th> 
        <th>Description</th>
        <th>Start_date</th>
        <th>End_date</th>
        <th>is_active</th>
        <th>Image</th>
        <th>Action</th>
        </tr>";
                foreach ($elections as $election) {
                    // Convertir les dates en objets DateTime pour comparaison
                    $start_date = new DateTime($election["start_date"]);
                    $end_date = new DateTime($election["end_date"]);
                    $current_date = new DateTime();

                    // Déterminer l'état de l'élection
                    if ($current_date >= $start_date && $current_date <= $end_date) {
                        $is_active = "Election en cours";
                    } elseif ($current_date > $end_date) {
                        $is_active = "Election terminée";
                    } else {
                        $is_active = "Election à venir";
                    }

                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($election["id_election"]) . "</td>";
                    echo "<td>" . htmlspecialchars($election["title"]) . "</td>";
                    echo "<td>" . htmlspecialchars($election["description"]) . "</td>";
                    echo "<td>" . htmlspecialchars($election["start_date"]) . "</td>";
                    echo "<td>" . htmlspecialchars($election["end_date"]) . "</td>";
                    echo "<td>" . htmlspecialchars($is_active) . "</td>"; // Afficher le texte descriptif
                    echo "<td><img src='images/" . htmlspecialchars($election["image"]) . "' class='w3-circle' style='width:46px'></td>";
                    echo "<td>
                <form action='see_more.php' method='GET'>
                    <button type='submit' name='id_election' value='" . htmlspecialchars($election["id_election"]) . "'>See More</button>
                </form>
              </td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Aucune élection trouvée.</p>";
            }
            ?>

        </div>

        <!-- Footer -->
        <footer class="w3-container w3-padding-16 w3-light-grey">
            <h4>AdventureHub</h4>
        </footer>

    </div>

    <script>
        // Toggle Sidebar
        function toggleSidebar() {
            var mySidebar = document.getElementById("mySidebar");
            var overlayBg = document.getElementById("myOverlay");
            if (mySidebar.style.display === 'block') {
                mySidebar.style.display = 'none';
                overlayBg.style.display = "none";
            } else {
                mySidebar.style.display = 'block';
                overlayBg.style.display = "block";
            }
        }
    </script>

</body>

</html>