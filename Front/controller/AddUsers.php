<?php

session_start();

require_once '../controller/UsersC.php';
require_once '../model/User.php';
require_once '../config.php';
require_once '../view/functions.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../view/phpmailer/src/PHPMailer.php';
require_once '../view/phpmailer/src/SMTP.php';

$pdo = config::getConnexion();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['userType'])) {
        $userType = $_POST['userType'];
    } else {
        $errors['userType'] = "Type d'utilisateur non défini";
    }
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    echo $userType;
    //var_dump($_POST) ;
//var_dump($_FILES);
    $controlElector = new electorC();
    $controlCandidat = new CandidatC();

    // Validation des champs
    /* Vérification du champ "identify_number"
    if (empty($_POST['identify_number']) || !preg_match("#^[a-zA-Z0-9_]+$#", $_POST['identify_number'])) {
        $errors['identify_number'] = "Votre pseudo n'est pas valide";
    } else {
        $query = "SELECT * FROM " . ($userType === 'elector' ? 'elector' : 'candidat') . " WHERE identify_number = ?";
        $req = $pdo->prepare($query);
        $req->execute([$_POST['identify_number']]);
        if ($req->fetch()) {
            $errors['identify_number'] = "Ce pseudo n'est plus disponible";
        }
    }*/

    // Validation des champs
    if (empty($_POST['username']) || !preg_match("#^[a-zA-Z0-9\s]+$#", $_POST['username'])) {
        $errors['username'] = "Votre pseudo n'est pas valide";
    } else {
        $query = $userType === 'elector' ? "SELECT * FROM elector WHERE username = ?" : "SELECT * FROM candidat WHERE username = ?";
        $req = $pdo->prepare($query);
        $req->execute([$_POST['username']]);
        if ($req->fetch()) {
            $errors['username'] = "Ce pseudo n'est plus disponible";
        }
    }

    // Vérification du champ "full_name"
    if (empty($_POST['full_name']) || !preg_match("#^[a-zA-Z0-9\s]+$#", $_POST['full_name'])) {
        $errors['full_name'] = "Votre nom complet n'est pas valide";
    } else {
        $query = $userType === 'elector' ? "SELECT * FROM elector WHERE full_name = ?" : "SELECT * FROM candidat WHERE full_name = ?";
        $req = $pdo->prepare($query);
        $req->execute([$_POST['full_name']]);
        if ($req->fetch()) {
            $errors['full_name'] = "Ce nom complet n'est plus disponible";
        }
    }

    // Validation du champ "email"
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Votre email n'est pas valide";
    } else {
        $query = $userType === 'elector' ? "SELECT * FROM elector WHERE email = ?" : "SELECT * FROM candidat WHERE email = ?";
        $req = $pdo->prepare($query);
        $req->execute([$_POST['email']]);
        if ($req->fetch()) {
            $errors['email'] = "Cette adresse mail est déjà prise";
        }
    }

    // Validation du champ "dob"
    if ($userType === 'elector') {
        if (empty($_POST['dob']) || !strtotime($_POST['dob'])) {
            $errors['dob'] = "Veuillez saisir une date de naissance valide";
        } else {
            $query = "SELECT * FROM elector WHERE dob = ?";
            $req = $pdo->prepare($query);
            $req->execute([$_POST['dob']]);
            if ($req->fetch()) {
                $errors['dob'] = "Cette date de naissance n'est plus disponible";
            }
        }
    }

    // Validation du champ "adresse"
    if (empty($_POST['adresse']) || !preg_match("#^[a-zA-Z0-9\s]+$#", $_POST['adresse'])) {
        $errors['adresse'] = "Votre adresse n'est pas valide";
    } else {
        $query = $userType === 'elector' ? "SELECT * FROM elector WHERE adresse = ?" : "SELECT * FROM candidat WHERE adresse = ?";
        $req = $pdo->prepare($query);
        $req->execute([$_POST['adresse']]);
        if ($req->fetch()) {
            $errors['adresse'] = "Cette adresse est déjà utilisée";
        }
    }

    // Vérification des champs spécifiques aux candidats
    if ($_POST['userType'] === 'candidat') {
        // Vérification du champ "biography"
        if (empty($_POST['biography']) || !preg_match("#^[a-zA-Z0-9\s]+$#", $_POST['biography'])) {
            $errors['biography'] = "Votre biographie n'est pas valide";
        }

        // Vérification du champ "program"
        if (empty($_POST['program']) || !preg_match("#^[a-zA-Z0-9_]+$#", $_POST['program'])) {
            $errors['program'] = "Votre programme n'est pas valide";
        }

        // Vérification du champ "political_party"
        if (empty($_POST['political_party']) || !preg_match("#^[a-zA-Z0-9_]+$#", $_POST['political_party'])) {
            $errors['political_party'] = "Votre parti politique n'est pas valide";
        }
    }
    // Validation du champ "image"
    if ($_POST['userType'] === 'candidat') {
        if (empty($_FILES['image']['name'])) {
            $errors['image'] = "Veuillez sélectionner une image";
        } else {
            if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                $errors['image'] = "Erreur lors de l'upload de l'image. Code d'erreur : " . $_FILES['image']['error'];
            } else {
                $image = $_FILES['image']['name'];
                $image_tmp = $_FILES['image']['tmp_name'];
                $image_extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));

                // Vérification de l'extension de l'image
                $allowed_extensions = array('jpg', 'jpeg', 'png');
                if (!in_array($image_extension, $allowed_extensions)) {
                    $errors['image'] = "Veuillez sélectionner une image avec une extension valide (jpg, jpeg ou png)";
                } else {
                    $query = "SELECT * FROM candidat WHERE image = ?";
                    $req = $pdo->prepare($query);
                    $req->execute([$image]);
                    if ($req->fetch()) {
                        $errors['image'] = "Cette image n'est plus disponible";
                    }
                }
            }
        }
    }


    function generateWalletAddress()
    {

        // Chemin complet vers node.js et votre script
        $nodePath = '"C:\\Program Files\\nodejs\\node.exe"'; // Notez les guillemets doubles
        $scriptPath = '"C:\\xampp\\htdocs\\gestion_vote\\Front\\controller\\Blockchain\\GenerateWalletAddress.js"'; // Notez les guillemets doubles

        // Commande shell
        $command = "$nodePath $scriptPath 2>&1";
        $address = shell_exec($command);
        echo "<pre>$address</pre>";
        if ($address === null || $address === '') {
            throw new Exception('Erreur lors de la génération de l\'adresse de portefeuille. Command output: ' . $address);
        }

        return trim($address);
    }

    $walletAddress = generateWalletAddress(); // Génération de l'adresse de portefeuille
    if (!$walletAddress) {
        $_SESSION['flash']['error'] = "Erreur lors de la génération de l'adresse de portefeuille.";
        return; // Arrêtez le script si l'adresse de portefeuille est invalide
    }
    echo "adresse: ";
    var_dump($walletAddress);


    // Si aucune erreur, procéder à l'ajout de l'utilisateur
    if (empty($errors)) {
        var_dump($errors);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $token = generateToken(100);
        $userId = 0;

        // Générer un identifiant unique
        $identify_number = generateUniqueIdentifyNumber($pdo);
        var_dump("on vient d'entrer");


        if ($userType === 'elector') {
            $type = 1;
            $newElector = new elector($identify_number, $_POST['username'], $_POST['full_name'], $_POST['email'], $_POST['dob'], $_POST['adresse'], $password, $userType);
            //var_dump($newCandidat); 
            if (!$controlElector->addElector($newElector)) {
                $_SESSION['flash']['error'] = "Une erreur s'est produite lors de la création de l'utilisateur.";
                header('Location:../view/login.php?userType=' . $userType);
                //exit();
            }
            $userId = $pdo->lastInsertId();

        } elseif ($userType === 'candidat') {

            var_dump("on vient d'entrer dans candidat");
            $type = 0;
            $newCandidat = new candidat($_POST['username'], $_POST['full_name'], $_POST['email'], $_POST['dob'], $_POST['adresse'], $_POST['biography'], $_POST['program'], $_POST['political_party'], $_FILES['image']['name'], $password, $userType);
            if (!$controlCandidat->addCandidat($newCandidat)) {
                var_dump("ici aussi ");
                $_SESSION['flash']['error'] = "Une erreur s'est produite lors de la création du candidat.";
                header('Location:../view/login.php?userType=' . $userType);
                //exit();
            }
            $userId = $pdo->lastInsertId();
            echo $userId;
            var_dump($userId);
            var_dump($userType);
        } else {
            $errors['userType'] = "Type d'utilisateur non reconnu";
        }

        if (empty($errors)) {
            // ENVOI DU MAIL
            $mail = new PHPMailer(true);
            $mailAddress = $_POST['email'];
            $headers = "From:gnine.diarra@esprit.tn";
            //Server settings
            $mail->isSMTP();                              //Send using SMTP
            $mail->Host = 'smtp.gmail.com';       //Set the SMTP server to send through
            $mail->SMTPAuth = true;             //Enable SMTP authentication
            $mail->Username = 'gnine.diarra@esprit.tn';   //SMTP write your email
            $mail->Password = 'fuupeumqyupsmbvd';      //SMTP password
            $mail->SMTPSecure = 'tls';            //Enable implicit SSL encryption
            $mail->Port = 587;
            //Recipients
            $mail->setFrom("gnine.diarra@esprit.tn", "AdventureHub"); // Sender Email and name
            $mail->addAddress($mailAddress);     //Add a recipient email  
            $mail->addReplyTo("gnine.diarra@esprit.tn", "AdventureHub"); // reply to sender email

            $message = "Afin de confirmer votre compte, merci de cliquer sur ce lien\n\n
        http://localhost/gestion_vote/Front/view/confirm.php?id=$userId&token=$token&type=$type";

            $subject = "confirmation du compte";
            //Content
            $mail->isHTML(true);               //Set email format to HTML
            $mail->Subject = $subject;   // email subject headings
            $mail->Body = $message; //email message

            try {
                $mail->send();
                $_SESSION['flash']['success'] = "Compte créé avec succès ! Veuillez vérifier votre boîte mail afin de confirmer votre compte.";
            } catch (Exception $e) {
                $_SESSION['flash']['error'] = "Une erreur s'est produite lors de l'envoi de l'e-mail de confirmation. Veuillez réessayer plus tard.";
                // Vous pouvez afficher les détails de l'erreur pour le débogage
                echo 'Erreur lors de l\'envoi de l\'e-mail : ', $mail->ErrorInfo;
            }
        } else {
            foreach ($errors as $error) {
                echo $error; // Afficher les erreurs à l'utilisateur
            }
        }
    }

    

}

?>