<?php
require_once '../controller/UsersC.php';
require_once '../model/User.php';
require_once '../config.php';
//require_once '../controller/loginController.php';
require_once '../view/functions.php';
session_start();

/* Vérifier si l'utilisateur est connecté en tant qu'administrateur
if (!isset($_SESSION['auth']) || !isset($_SESSION['auth']['id'])) {
    $_SESSION['flash']['danger'] = "Vous devez vous connecter en tant qu'administrateur.";
    header("Location: login.php"); // Rediriger vers la page de connexion
    exit();
}*/
$controlNotif = new NotificationC();
$errors = []; 

// Récupérer les données du formulaire
if (isset($_POST['recipientType']) && isset($_POST['recipient_id']) && isset($_POST['message'])) {
    
    $recipient_type = $_POST['recipientType'];
    $recipient_id = $_POST['recipient_id'];
    $message = $_POST['message'];

    // Vérifier le type de destinataire et récupérer les informations nécessaires
    switch ($recipientType) {
        case 'elector':
            $recipient = new electorC();
            $recipient_table = 'elector';
            break;
        case 'candidat':
            $recipient = new CandidatC();
            $recipient_table = 'candidat';
            break;
        default:
            $_SESSION['flash']['danger'] = "Type de destinataire invalide.";
            header("Location: ../view/ReadUsers.php"); // Rediriger vers le tableau de bord de l'administrateur
            exit();
    }

    // Récupérer les informations du destinataire à partir de la base de données
    $pdo = config::getConnexion();
    $query = "SELECT * FROM $recipient_table WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$recipient_id]);
    $recipient_info = $stmt->fetch(PDO::FETCH_ASSOC);

//l'ajout 


    if (!$recipient_info) {
        $_SESSION['flash']['danger'] = "Destinataire introuvable.";
        header("Location: ../view/ReadUsers.php"); // Rediriger vers le tableau de bord de l'administrateur
        exit();
    }

    // Enregistrer la notification dans la base de données
    $notification = new notification($recipientType,$recipient_id, $message, date('Y-m-d H:i:s'), 'unread');
    // Code pour enregistrer la notification dans la base de données
    
    $controlNotif->addNotification($notification);

    


    $_SESSION['flash']['success'] = "Notification envoyée avec succès.";
    header("Location: ../view/ReadUsers.php"); // Rediriger vers le tableau de bord de l'administrateur
    exit();
} else {
    var_dump("test");
    $_SESSION['flash']['danger'] = "Tous les champs sont obligatoires.";
    header("Location: ../view/ReadUsers.php"); // Rediriger vers le tableau de bord de l'administrateur
    exit();
}
?>
