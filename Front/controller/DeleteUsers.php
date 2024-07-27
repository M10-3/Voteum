<?php
require_once '../controller/UsersC.php';
require_once '../model/User.php';
require_once '../config.php';
session_start();

if (isset($_SESSION["type"])) {
    $userId = $_SESSION["userId"];
    echo 'User ID: ' . $userId;

    if ($_SESSION["type"] === "elector") {
        $control = new electorC();
        echo 'User ID: ' . $userId;
        $control->deleteElector($userId);

        $_SESSION = array();
        session_destroy();
        header("location:../view/index.php");
    } elseif ($_SESSION["type"] === "candidat") {
        $control = new CandidatC();
        echo 'User ID: ' . $userId;
        $control->deleteCandidat($userId);

        $_SESSION = array();
        session_destroy();
        header("location:../view/index.php");
    }
} else {
    var_dump("non la cle n'est pas defini dans session");
}
?>
