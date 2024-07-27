<?php
require_once '../controller/UsersC.php';
require_once '../model/User.php';
require_once '../config.php';
//require_once '../controller/loginController.php';
require_once '../view/functions.php';
session_start();

// Vérifier que l'ID d'élection est présent et valide
if (!isset($_GET['id_election']) || !is_numeric($_GET['id_election'])) {
    die('ID d\'élection invalide.');
}

$id_election = intval($_GET['id_election']);
$electionController = new ElectionC();
// Supprimer l'élection de la base de données
$electionController->deleteElection($id_election);
$_SESSION = array();
        session_destroy();

/*try {
    // Récupérer les détails de l'élection pour obtenir le nom de l'image
    $election = $electionController->getElectionById($id_election);
    if (!$election) {
        die('Élection non trouvée.');
    }

    // Supprimer l'image du serveur si elle existe
    $imagePath = '../uploads/' . $election['image'];
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Supprimer l'élection de la base de données
    $electionController->deleteElection($id_election);
    
    $_SESSION['flash']['success'] = "L'élection a été supprimée avec succès.";
} catch (Exception $e) {
    $_SESSION['flash']['danger'] = "Erreur lors de la suppression de l'élection : " . $e->getMessage();
}

// Détruire la session
$_SESSION = array();
session_destroy();*/

// Rediriger vers la liste des élections
header("Location: http://localhost/gestion_vote/Back/view/ReadUsers.php");
exit();
?>
