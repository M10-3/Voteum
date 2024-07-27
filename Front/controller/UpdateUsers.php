<?php
require_once '../controller/UsersC.php';
require_once '../model/User.php';
require_once '../config.php';
require_once '../controller/loginController.php';
require_once '../view/functions.php';
session_start();
// Debugging output
echo '<pre>';
print_r($_SESSION);
print_r($_POST);
echo '</pre>';

if (isset($_SESSION["userId"]) && isset($_SESSION["type"])) {
    $userId = $_SESSION["userId"];
    $userType = $_SESSION["type"];
    echo 'User ID: ' . $userId;

    if ($_SESSION["type"] === "elector") {
        $control = new electorC();
        if (isset($_POST['newUsername'])) {
            $newUserName = $_POST['newUsername'];
            $control->updateElectorUsername($newUserName, $userId);
            header("location:../view/profil_elector.php");
        } elseif (isset($_POST['newFull_name'])) {
            $newFull_name = $_POST['newFull_name'];
            $control->updateElectorFull_name($newFull_name, $userId);
            header("location:../view/profil_elector.php");
        } elseif (isset($_POST['newEmail'])) {
            $newEmail = $_POST['newEmail'];
            $control->updateElectorEmail($newEmail, $userId);
            header("location:../view/profil_elector.php");
        } elseif (isset($_POST['newDob'])) {
            $newDob = $_POST['newDob'];
            $control->updateElectorDob($newDob, $userId);
            header("location:../view/profil_elector.php");
        } elseif (isset($_POST['newAdresse'])) {
            $newAdresse = $_POST['newAdresse'];
            $control->updateElectorAdresse($newAdresse, $userId);
            header("location:../view/profil_elector.php");
        } elseif (isset($_POST['newPassword']) && isset($_POST['confirmPassword'])) {
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];
            if ($newPassword === $confirmPassword) {
                $cryptedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $control->updateElectorPassword($cryptedNewPassword, $userId);
                header("location:../view/profil_elector.php");
            } else {
                header("location:../view/profil_elector.php?error=password_mismatch");
            }
        }
    } elseif ($_SESSION["type"] === "candidat") {
        $control = new CandidatC();
        if (isset($_POST['newUsername'])) {
            $newUserName = $_POST['newUsername'];
            $control->updateCandidatUsername($newUserName, $userId);
            header("location:../view/profil_candidat.php");
        }else if (isset($_POST['newFull_name'])) {
            $newFull_name = $_POST['newFull_name'];
            $control->updateCandidatFull_name($newFull_name, $userId);
            header("location:../view/profil_candidat.php");
        } elseif (isset($_POST['newEmail'])) {
            $newEmail = $_POST['newEmail'];
            $control->updateCandidatEmail($newEmail, $userId);
            header("location:../view/profil_candidat.php");
        } elseif (isset($_POST['newAdresse'])) {
            $newAdresse = $_POST['newAdresse'];
            $control->updateCandidatAdresse($newAdresse, $userId);
            header("location:../view/profil_candidat.php");
        } elseif (isset($_POST['newBiography'])) {
            $newBiography = $_POST['newBiography'];
            $control->updateCandidatBiography($newBiography, $userId);
            header("location:../view/profil_candidat.php");
        } elseif (isset($_POST['newProgram'])) {
            $newProgram = $_POST['newProgram'];
            $control->updateCandidatProgram($newProgram, $userId);
            header("location:../view/profil_candidat.php");
        } elseif (isset($_POST['newPolitical_party'])) {
            $newPolitical_party = $_POST['newPolitical_party'];
            $control->updateCandidatPolitical_party($newPolitical_party, $userId);
            //header("location:../view/profil_candidat.php");
        } elseif (isset($_FILES['newImage'])) {
            $newImage = $_FILES['newImage'];
            if ($newImage['error'] === UPLOAD_ERR_OK) {
                $tempFilePath = $newImage['tmp_name'];
                $destination = "../image/" . $newImage['name'];
                move_uploaded_file($tempFilePath, $destination);
                $control->updateCandidatImage($destination, $userId);
                header("location:../view/profil_candidat.php");
            } else {
                echo "Une erreur s'est produite lors du téléchargement du fichier.";
            }
        } elseif (isset($_POST['oldPassword']) && isset($_POST['newPassword']) && isset($_POST['confirmPassword'])) {
            $oldPassword = $_POST['oldPassword'];
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];
            if ($newPassword === $confirmPassword) {
                $candidat = checkCandidat($userId);
                if ($candidat != NULL) {
                    $cryptedPassword = $candidat['password'];
                    if (password_verify($oldPassword, $cryptedPassword) == false) {
                        header("Location:../view/profil_candidat.php?error=wrong_password");
                    } else {
                        $cryptedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                        $control->updateCandidatPassword($cryptedNewPassword, $userId);
                        header("location:../view/profil_candidat.php");
                    }
                }
            } else {
                header("location:../view/profil_candidat.php?error=password_mismatch");
            }
        }
    }
} else {
    var_dump("non la cle n'est pas defini dans session");
}
?>
