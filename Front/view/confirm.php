<?php
session_start();

require_once '../config.php';

$userId = $_GET['id'];
$token = $_GET['token'];
$type = $_GET['type'];

// Vérifiez que $userId est défini et est un entier
if (!isset($userId) || !is_numeric($userId)) {
    $_SESSION['flash']['danger'] = "ID utilisateur invalide";
    header('Location: ../view/register.html');
    exit();
}

// Vérifiez que $type est défini et est un entier
if (!isset($type) || !in_array($type, [0, 1])) {
    $_SESSION['flash']['danger'] = "Type d'utilisateur invalide";
    header('Location: ../view/register.html');
    exit();
}

$pdo = config::getConnexion();

try {
    if ($type == 1) {
        // Pour les électeurs
        $query = "SELECT * FROM elector WHERE id_elector = ?";
        $req = $pdo->prepare($query);
        $req->execute([$userId]);
        $elector = $req->fetch();

        if ($elector) {
            // Exemple de vérification du token (décommentez si vous avez un token)
            // if ($token == $elector['confirmation_token']) {
            $query = "UPDATE elector SET confirmation_token = NULL, confirmation_at = NOW() WHERE id_elector = ?";
            $req = $pdo->prepare($query);
            $req->execute([$userId]);
            $_SESSION['flash']['success'] = "Votre compte a bien été validé";
            $_SESSION['auth'] = $elector;
            header('Location: ../view/login.php');
            exit();
            // }
        } else {
            $_SESSION['flash']['danger'] = "Ce compte n'existe pas";
            header('Location: ../view/register.html');
            exit();
        }
    } else {
        // Pour les candidats
        $query = "SELECT * FROM candidat WHERE id_candidat = ?";
        $req = $pdo->prepare($query);
        $req->execute([$userId]);
        $candidat = $req->fetch();

        if ($candidat) {
            // Exemple de vérification du token (décommentez si vous avez un token)
            // if ($token == $candidat['confirmation_token']) {
            $query = "UPDATE candidat SET confirmation_token = NULL, confirmation_at = NOW() WHERE id_candidat = ?";
            $req = $pdo->prepare($query);
            $req->execute([$userId]);
            $_SESSION['flash']['success'] = "Votre compte a bien été validé";
            $_SESSION['auth'] = $candidat;
            header('Location: ../view/login.php');
            exit();
            // }
        } else {
            $_SESSION['flash']['danger'] = "Ce compte n'existe pas";
            header('Location: ../view/register.html');
            exit();
        }
    }
} catch (PDOException $e) {
    $_SESSION['flash']['danger'] = "Une erreur est survenue : " . $e->getMessage();
    header('Location: ../view/register.html');
    exit();
}
?>
