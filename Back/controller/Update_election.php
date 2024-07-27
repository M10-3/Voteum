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
$election = $electionController->getElectionById($id_election);

if (!$election) {
    die('Élection non trouvée.');
}

// Traitement du formulaire de mise à jour
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Déterminer si l'élection est active ou non
    $is_active = (new DateTime($start_date) <= new DateTime() && new DateTime() <= new DateTime($end_date)) ? "Election en cours" : "Election non active";

    // Gestion de l'image
    $image = $election['image']; // Valeur par défaut si aucune nouvelle image n'est téléchargée
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $image = basename($_FILES['image']['name']);
        } else {
            $_SESSION['flash']['danger'] = "Erreur lors du téléchargement de l'image.";
            header("Location: Update_election.php?id_election=" . $id_election);
            exit();
        }
    }

    $updatedElection = new Election($title, $image, $description, $start_date, $end_date, $is_active);
    $electionController->updateElection($id_election, $updatedElection);

    $_SESSION['flash']['success'] = "L'élection a été mise à jour avec succès.";
    header("Location: http://localhost/gestion_vote/Back/view/ReadUsers.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>Modifier l'Élection</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
    <div class="container">
        <h1>Modifier l'Élection</h1>

        <form action="Update_election.php?id_election=<?php echo htmlspecialchars($id_election); ?>" method="POST" enctype="multipart/form-data">
            <div>
                <label for="title">Titre :</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($election['title']); ?>" required>
            </div>
            <div>
                <label for="description">Description :</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($election['description']); ?></textarea>
            </div>
            <div>
                <label for="start_date">Date de Début :</label>
                <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($election['start_date']); ?>" required>
            </div>
            <div>
                <label for="end_date">Date de Fin :</label>
                <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($election['end_date']); ?>" required>
            </div>
            <div>
                <label for="image">Image actuelle :</label>
                <img src="../uploads/<?php echo htmlspecialchars($election['image']); ?>" alt="Image de l'élection" class="img-fluid" style="max-width: 200px;">
            </div>
            <div>
                <label for="image">Nouvelle Image (laisser vide pour ne pas changer) :</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <button type="submit">Mettre à jour</button>
        </form>

        <a href="http://localhost/gestion_vote/Back/view/ReadUsers.php">Retour à la liste des élections</a>
    </div>
</body>
</html>
