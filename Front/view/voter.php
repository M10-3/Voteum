<?php
require_once '../controller/UsersC.php';
require_once '../model/User.php';
require_once '../config.php';
//require_once '../controller/loginController.php';
require_once '../view/functions.php';
session_start();

if (!isset($_SESSION['userId'])) {
    die('Accès non autorisé.');
}

$db = config::getConnexion();
$voteC = new VoteC();

// Vérifier la méthode de la requête
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérifier que les paramètres sont présents et valides
    if (!isset($_POST['id_election'], $_POST['id_candidat']) || !is_numeric($_POST['id_election']) || !is_numeric($_POST['id_candidat'])) {
        die('Paramètres invalides.');
    }

    $id_election = intval($_POST['id_election']);
    $id_candidat = intval($_POST['id_candidat']);
    $userId = $_SESSION['userId'];

    // Vérifier si l'élection et le candidat existent
    $electionQuery = $db->prepare('SELECT * FROM election WHERE id_election = :id_election');
    $electionQuery->execute(['id_election' => $id_election]);
    $election = $electionQuery->fetch();

    $candidatQuery = $db->prepare('SELECT * FROM candidat WHERE id_candidat = :id_candidat AND id_election = :id_election');
    $candidatQuery->execute([
        'id_candidat' => $id_candidat,
        'id_election' => $id_election
    ]);
    $candidat = $candidatQuery->fetch();

    if (!$election || !$candidat) {
        die('Élection ou candidat invalide.');
    }

    // Créer un objet Vote et ajouter le vote
    $vote = new vote($userId, $id_candidat, $id_election);

    $voteC->addVote($vote);

    $_SESSION['flash']['success'] = "Votre vote a été enregistré avec succès.";
    header("Location: page_vote.php?id_election=" . $id_election); // Recharger la page pour afficher le message de succès
    exit();
}

// Vérifier que l'id_election est présent dans les paramètres GET
if (!isset($_GET['id_election']) || !is_numeric($_GET['id_election'])) {
    die('ID d\'élection invalide.');
}

$id_election = intval($_GET['id_election']);

// Récupérer les détails de l'élection
$electionQuery = $db->prepare('SELECT * FROM election WHERE id_election = :id_election');
$electionQuery->execute(['id_election' => $id_election]);
$election = $electionQuery->fetch();

// Vérifier si l'élection existe
if (!$election) {
    die('Élection non trouvée.');
}

// Récupérer les candidats pour cette élection
$candidatsQuery = $db->prepare('SELECT * FROM candidat WHERE id_election = :id_election');
$candidatsQuery->execute(['id_election' => $id_election]);
$candidats = $candidatsQuery->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vote pour l'Élection</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .election-details {
            margin-bottom: 20px;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center mb-5">Voter pour l'Élection</h1>
    
    <?php if (isset($_SESSION['flash']['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['flash']['success']; ?>
            <?php unset($_SESSION['flash']['success']); ?>
        </div>
    <?php endif; ?>

    <div class="election-details">
        <h2><?php echo htmlspecialchars($election['title']); ?></h2>
        <img src="../images/<?php echo htmlspecialchars($election['image']); ?>" class="img-fluid" alt="Image de l'élection">
        <p><?php echo htmlspecialchars($election['description']); ?></p>
        <p><strong>Début :</strong> <?php echo htmlspecialchars($election['start_date']); ?></p>
        <p><strong>Fin :</strong> <?php echo htmlspecialchars($election['end_date']); ?></p>
    </div>
    
    <?php if (strtotime($election['end_date']) > time()): ?>
        <!-- Afficher le formulaire de vote uniquement si l'élection est encore active -->
        <form action="voter.php?id_election=<?php echo htmlspecialchars($id_election); ?>" method="post">
            <input type="hidden" name="id_election" value="<?php echo htmlspecialchars($id_election); ?>">
            
            <?php foreach ($candidats as $candidat): ?>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="id_candidat" id="candidat_<?php echo htmlspecialchars($candidat['id_candidat']); ?>" value="<?php echo htmlspecialchars($candidat['id_candidat']); ?>" required>
                    <label class="form-check-label" for="candidat_<?php echo htmlspecialchars($candidat['id_candidat']); ?>">
                        <?php echo htmlspecialchars($candidat['full_name']); ?>
                    </label>
                </div>
            <?php endforeach; ?>
            
            <button type="submit" class="btn btn-primary mt-3">Soumettre mon vote</button>
        </form>
    <?php else: ?>
        <!-- Message indiquant que l'élection est terminée -->
        <p class="text-danger">Cette élection est terminée. Vous ne pouvez plus voter.</p>
    <?php endif; ?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
