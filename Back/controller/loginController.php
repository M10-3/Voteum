<?php
session_start();

require_once '../config.php';
require_once '../view/functions.php';
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
/*Affiche le chemin de l'image actuelle avant de traiter la requête
if (isset($_SESSION['image'])) {
    echo "Chemin de l'image actuelle : " . $_SESSION['image'];
} else {
    echo "Aucune image actuelle définie dans la session.";
}
echo "Chemin de l'image actuelle : " . $_POST['userType'];
*/
$pdo = config::getConnexion();
if (isset($_POST['userType']) && $_POST['userType'] === 'admin') {
    reconnect_auto();
//if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])) {
    $query = "SELECT * FROM admin WHERE email = :email AND confirmation_at IS NOT NULL";
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
                $query = "UPDATE admin SET remember_token = ? WHERE id_admin = ?";
                $pdo->prepare($query)->execute([$remember_token, $user['id_admin']]);
                setcookie("remember", $user['id_admin'] . "::" . $remember_token . sha1($user['id_admin'] . "AdventureHub"), time() + 60 * 60 * 24 * 7);
            }
    /* Récupération de userType
    $userType = isset($_POST['userType']) ? $_POST['userType'] : 'admin';

    // Définition de la condition de recherche en fonction de userType
    if ($userType === 'admin') {
        $query = "SELECT * FROM admin WHERE (username = :username OR email = :email) AND confirmation_at IS NOT NULL";
    } else {
        // Ajoutez d'autres conditions pour différents types d'utilisateurs si nécessaire
        // Exemple:
        // $query = "SELECT * FROM other_users WHERE (username = :username OR email = :email) AND confirmation_at IS NOT NULL";
    }

    $req = $pdo->prepare($query);
    $req->execute([
        'username' => $_POST['username'],
        'email' => $_POST['email']
    ]);
    $user = $req->fetch(PDO::FETCH_ASSOC);

    // Débogage : Afficher toutes les clés du tableau
    echo "<pre>";
    print_r($user);
    echo "</pre>";

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['auth'] = $user;
        $_SESSION['flash']['success'] = "Connexion effectuée avec succès";

        if (isset($_POST['remember'])) {
            $remember_token = generateToken(100);
            $query = "UPDATE admin SET remember_token = ? WHERE id_admin = ?";
            $pdo->prepare($query)->execute([$remember_token, $user['id_admin']]);
            // Stocker le jeton dans le cookie
            setcookie("remember", $user['id_admin'] . "::" . $remember_token . sha1($user['id_admin'] . "AdventureHub"), time() + 60 * 60 * 24 * 7);
        }*/
        $_SESSION["userId"] = $user["id_admin"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["image"] = isset($user["image"]) ? $user["image"] : 'default_image.jpg'; // Valeur par défaut
        $_SESSION["password"] = $user["password"];

        header("Location: ../view/ReadUsers.php");
        exit();
    } else {
        $_SESSION['flash']['danger'] = "Identifiant ou Mot de passe incorrect";
        header("Location: ../view/login.php");
    }
}
?>
