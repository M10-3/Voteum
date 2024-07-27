<?php
session_start();

require_once '../config.php';

$userId = $_GET['id'];


var_dump($userId);
$token = $_GET['token'];
$pdo = config::getConnexion();

$query = "SELECT * FROM admin WHERE id_admin= ?";
$req = $pdo->prepare($query);
$req->execute([$userId]);
$user = $req->fetch();
if ($user /*&& $token == $user->confirmation_token*/) {
      $query = "UPDATE admin SET confirmation_token = NULL, confirmation_at = NOW() WHERE id_admin= ?";
      $req = $pdo->prepare($query);
      $req->execute([$userId]);
      $_SESSION['flash']['success'] = "Votre compte a bien été validé";
      $_SESSION['auth'] = $user;

    header('Location: login.php');
} else {
      $_SESSION['flash']['danger'] = "Ce compte n'existe pas";
     header('Location: register.html');// on ramène l'utilisateur sur register
}