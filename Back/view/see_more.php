<?php
session_start();
require_once '../config.php';

// Vérifier que l'ID d'élection est présent et valide
if (!isset($_GET['id_election']) || !is_numeric($_GET['id_election'])) {
    die('ID d\'élection invalide.');
}

$id_election = intval($_GET['id_election']);
$db = config::getConnexion();

// Récupérer les détails de l'élection
$electionQuery = $db->prepare('SELECT * FROM election WHERE id_election = :id_election');
$electionQuery->execute(['id_election' => $id_election]);
$election = $electionQuery->fetch();

if (!$election) {
    die('Élection non trouvée.');
}

// Convertir les dates en objets DateTime pour comparaison
$start_date = new DateTime($election["start_date"]);
$end_date = new DateTime($election["end_date"]);
$current_date = new DateTime();

// Déterminer l'état de l'élection
if ($current_date >= $start_date && $current_date <= $end_date) {
    $is_active = "Election en cours";
} elseif ($current_date > $end_date) {
    $is_active = "Election terminée";
} else {
    $is_active = "Election à venir";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>Détails de l'Élection</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
    <div class="container">
        <h1>Détails de l'Élection</h1>

        <div>
            <h2><?php echo htmlspecialchars($election['title']); ?></h2>
            <img src="../uploads/<?php echo htmlspecialchars($election['image']); ?>" class="img-fluid" alt="Image de l'élection">
            <p><strong>Description :</strong> <?php echo htmlspecialchars($election['description']); ?></p>
            <p><strong>Date de Début :</strong> <?php echo htmlspecialchars($election['start_date']); ?></p>
            <p><strong>Date de Fin :</strong> <?php echo htmlspecialchars($election['end_date']); ?></p>
            <p><strong>État :</strong> <?php echo htmlspecialchars($is_active); ?></p>
        </div>

        <div>
            <form action="http://localhost/gestion_vote/Back/controller/Update_election.php" method="GET" style="display:inline;">
                <input type="hidden" name="id_election" value="<?php echo htmlspecialchars($id_election); ?>">
                <button type="submit">Modifier</button>
            </form>

            <form action="http://localhost/gestion_vote/Back/controller/Delete_election.php" method="GET" style="display:inline;">
                <input type="hidden" name="id_election" value="<?php echo htmlspecialchars($id_election); ?>">
                <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette élection ?');">Supprimer</button>
            </form>
        </div>

        <a href="http://localhost/gestion_vote/Back/view/ReadUsers.php">Retour à la liste des élections</a> <!-- Modifiez le lien selon votre structure -->
    </div>
</body>
</html>
