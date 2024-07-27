<?php
include_once "../config.php";
$pdo = config::getConnexion();
function generateToken($length)
{
    $alphanum = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    //var_dump(strstr(str_shuffle(str_repeat($alphanum, 100)),0,100));
    return substr(str_shuffle(str_repeat($alphanum, $length)), 0, $length);

}

function generateUniqueIdentifyNumber($pdo) {
    do {
        $identify_number = uniqid('Id_', true);
        $query = "SELECT COUNT(*) FROM elector WHERE identify_number = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$identify_number]);
        $count = $stmt->fetchColumn();
    } while ($count > 0);

    return $identify_number;
}

function is_connect()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['auth'])) {
        $_SESSION['flash']['danger'] = "Vous ne pouvez pas accéder à cette page";
        header("Location: ../view/login.php");
        exit();
    }
}

function reconnect_auto_elector()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_COOKIE['remember']) && !isset($_SESSION['auth'])) {
        require_once '../config.php';
        if (!isset($pdo)) {
            global $pdo;
        }
        $remember_token = $_COOKIE['remember'];
        $parts = explode("::", $remember_token);
        $userId = $parts[0];
        $req = $pdo->prepare("SELECT * FROM elector WHERE id = ?");
        $req->execute([$userId]);
        $elector = $req->fetch();

        if ($elector) {
            $expected = $userId . "::" . $elector->remember_token . sha1($elector->id . "AdventureHub");
            if ($expected == $_COOKIE['remember']) {
                $_SESSION["auth"] = $elector;
                $_SESSION['flash']['success'] = "Connexion effectuée avec succès";

                setcookie("remember", $remember_token, time() + 60 * 60 * 24 * 7);
                header("Location: index.php");
                exit();
            } else {
                setcookie("remember", "", -1);
            }
        } else {
            setcookie("remember", "", -1);
        }
    }
}

function reconnect_auto_candidat()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_COOKIE['remember']) && !isset($_SESSION['auth'])) {
        require_once '../config.php';
        if (!isset($pdo)) {
            global $pdo;
        }
        $remember_token = $_COOKIE['remember'];
        $parts = explode("::", $remember_token);
        $userId = $parts[0];
        $req = $pdo->prepare("SELECT * FROM candidat WHERE id = ?");
        $req->execute([$userId]);
        $candidat = $req->fetch();

        if ($candidat) {
            $expected = $userId . "::" . $candidat->remember_token . sha1($candidat->id . "AdventureHub");
            if ($expected == $_COOKIE['remember']) {
                $_SESSION["auth"] = $candidat;
                $_SESSION['flash']['success'] = "Connexion effectuée avec succès";

                setcookie("remember", $remember_token, time() + 60 * 60 * 24 * 7);
                header("Location: index.php");
                exit();
            } else {
                setcookie("remember", "", -1);
            }
        } else {
            setcookie("remember", "", -1);
        }
    }
}

function checkElector($userId){

    $db = config::getConnexion();
    try {
        $query = $db->prepare(
            'SELECT * FROM elector WHERE id = :id'
        );
        $query->execute([
            'id' => $userId
        ]);
        return $query->fetch();
    } catch (PDOException $e) {
        error_log('Erreur lors de laffichage de l\'utilisateur: ' . $e->getMessage());
        echo 'Erreur lors de laffichage de l\'utilisateur.';
    }
}

function checkCandidat($userId){
    $db = config::getConnexion();
    try {
        $query = $db->prepare(
            'SELECT * FROM candidat WHERE id = :id'
        );
        $query->execute([
            'id' => $userId
        ]);
        return $query->fetch(); // Retourne le résultat de la requête
    } catch (PDOException $e) {
        error_log('Erreur lors de laffichage de lagence: ' . $e->getMessage());
        echo 'Erreur lors de laffichage de lagence.';
    }
}