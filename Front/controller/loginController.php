<?php
//session_start();
require_once '../view/functions.php';
//is_connect();
require_once '../config.php';
var_dump("on vient d'entrer dans loginController");
//echo $_POST['userType'];
//echo $_POST['email'];
//echo $_POST['password'];
if (isset($_POST['userType']) && $_POST['userType'] === 'elector') {

    reconnect_auto_elector();
    $pdo = config::getConnexion();
    if (!empty($_POST) && !empty($_POST['email']) && !empty($_POST['password'])) {
        $query = "SELECT * FROM elector WHERE email = :email AND confirmation_at IS NOT NULL";
        $req = $pdo->prepare($query);
        $req->execute([
            'email' => $_POST['email']
        ]);
        $user = $req->fetch();
    
        var_dump($user);
    
        if ($user != null && password_verify($_POST['password'], $user['password'])) {
            $_SESSION['flash']['success'] = "Connexion effectuée avec succès";
            $_SESSION['auth'] = $user;
    
            if (isset($_POST['remember'])) {
                $remember_token = generateToken(100);
                $query = "UPDATE elector SET remember_token = ? WHERE id_elector = ?";
                $pdo->prepare($query)->execute([$remember_token, $user['id_elector']]);
                setcookie("remember", $user['id_elector'] . "::" . $remember_token . sha1($user['id_elector'] . "AdventureHub"), time() + 60 * 60 * 24 * 7);
            }
            $_SESSION["userId"] = $user["id_elector"];
            $_SESSION["identify_number"] = $user["identify_number"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["full_name"] = $user["full_name"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["dob"] = $user["dob"];
            $_SESSION["adresse"] = $user["adresse"];
            $_SESSION["password"] = $user["password"];
            $_SESSION["type"] = "elector";
    
            header("Location: ../view/index.php");
            //exit();
        } else {
            $_SESSION['flash']['danger'] = "Identifiant ou Mot de passe incorrect";
            header("Location: ../view/login.php");
        }
    }
    $userType = $_POST['userType'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
}

if (isset($_POST['userType']) && $_POST['userType'] === 'candidat') {
    reconnect_auto_candidat();
    $pdo = config::getConnexion();
    if (!empty($_POST) && !empty($_POST['email']) && !empty($_POST['password'])) {
        $query = "SELECT * FROM candidat WHERE email = :email AND confirmation_at IS NOT NULL";
        $req = $pdo->prepare($query);
        //$req->execute(['username' => $_POST['username']]);
        $req->execute([
            'email' => $_POST['email']
        ]);
        $user = $req->fetch();
        var_dump($user);
        if ($user && password_verify($_POST['password'], $user['password'])) {
            $_SESSION['flash']['success'] = "Connexion effectuée avec succès";
            $_SESSION['auth'] = $user;

            if (isset($_POST['remember'])) {
                $remember_token = generateToken(100);
                $query = "UPDATE candidat SET remember_token = ? WHERE id_candidat = ?";
                $pdo->prepare($query)->execute([$remember_token, $user->id_candidat]);
                //stocker le jeton dans le cookie
                setcookie("remember", $user->id_candidat . "::" . $remember_token . sha1($user->id_candidat . "AdventureHub"), time() + 60 * 60 * 24 * 7);
            }
            $_SESSION["userId"] = $user["id_candidat"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["full_name"] = $user["full_name"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["dob"] = $user["dob"];
            $_SESSION["adresse"] = $user["adresse"];
            $_SESSION["biography"] = $user["biography"];
            $_SESSION["program"] = $user["program"];
            $_SESSION['political_party'] = $user["political_party"];
            $_SESSION["image"] = $user["image"];
            $_SESSION["password"] = $user["password"];
            $_SESSION["type"] = "candidat";


            header("Location: ../view/index.php");
            exit();
        } else {
            $_SESSION['flash']['danger'] = "Identifiant ou Mot de passe incorrect";
            header("Location: ../view/login.php");
            //var_dump("erreur surr nous");
        }
    }
}

?>