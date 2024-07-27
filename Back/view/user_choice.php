<?php

include_once "../config.php";
$userId=$_POST["userId"];
/*
if (!isset($_SESSION['auth'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['auth'];
*/
if (!isset($_POST['userId'], $_POST['recipientType'])) {
    die('Données manquantes.');
}

$userId = intval($_POST['userId']);
$recipientType = $_POST['recipientType'];

if (!in_array($recipientType, ['candidat', 'elector'])) {
    die('Type de destinataire invalide.');
}
?>
<!DOCTYPE html>
<html>
<head>
<title>AdventureHub</title>
<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />

    <link rel="stylesheet" href="assets/css/main.css" />
<link rel="icon" href="images/logo.png" type="image/png">

<style>
        /* CSS pour le header et les éléments */
        .header {
            position: relative;
            padding: 10px;
            background-color: #f8f9fa; /* Ajustez la couleur de fond si nécessaire */
            border-bottom: 1px solid #dee2e6; /* Ajoutez une bordure si désiré */
        }

        .header img {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 150px; /* Ajustez la taille de l'image selon vos besoins */
            height: auto;
        }

        .notification-button {
            position: absolute;
            top: 0px;
            right: 0px;
            background-color: #3498db; /* Couleur du bouton, ajustez si nécessaire */
            color: white;
            border: none;
            border-radius: 4px;
            padding: 20px;
            cursor: pointer;
            font-size: 20px;
        }

        .notification-button i {
            margin: 0;
        }
    </style>
<body class="w3-light-grey">
    <style>
        body{
            font-family: "Montserrat", sans-serif;
      font-optical-sizing: auto;
      font-style: normal;
        }
    </style>


<header class="header">
        <button id="notificationButton" class="notification-button" onclick="openModal()">
            <i class="fas fa-bell"></i>
        </button>
        <a href="http://localhost/gestion_vote/Front/view/index.php">
            <img src="http://localhost/gestion_vote/Back/view/images/logo.png" alt="Voteum Logo" />
        </a>
    </header>
<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Dashboard</b></h5>
  </header>

  <form action="../controller/process_notif.php" method="POST">
    <label for="recipient_type">Type de destinataire :</label>
    <input type="text" name="recipient_type" id="recipient_type" value=<?php echo $recipientType  ?> >
    <br>
  
    <label for="recipient_id">ID du destinataire :</label>
    <input type="text" name="recipient_id" id="recipient_id" value=<?php echo $userId  ?> >
    <br>
  
    <label for="message">Message :</label><br>
    <textarea name="message" id="message" rows="4" cols="50"></textarea>
    <br>
  
    <input type="submit" value="Envoyer la notification">
  </form>
  

<!-- Footer -->
<footer class="w3-container w3-padding-16 w3-light-grey">
    <h4>Voteum</h4>
  </footer>

  <!-- End page content -->
</div>

<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
    overlayBg.style.display = "none";
  } else {
    mySidebar.style.display = 'block';
    overlayBg.style.display = "block";
  }
}

// Close the sidebar with the close button
function w3_close() {
  mySidebar.style.display = "none";
  overlayBg.style.display = "none";
}
</script>

</body>
</html>
