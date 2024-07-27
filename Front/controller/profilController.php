<?php
session_start();
require_once '../config.php';
require_once '../view/functions.php';

if (!isset($_SESSION['type'])) {
    echo "Type non défini dans la session.";
    exit();
}

if ($_SESSION['type'] == 'elector') {
    header("Location: http://localhost/gestion_vote/Front/view/profil_elector.php");
} else {
    header("Location: ../view/profil_candidat.php");
}
exit(); // Assurez-vous que le script s'arrête après la redirection.
