<?php
session_start();
include_once "../config.php";
if (!isset($_SESSION['userId'])) {
    die('Accès non autorisé.');

}


$db = config::getConnexion();

// Récupérer toutes les élections
$query = $db->prepare('SELECT * FROM election');
$query->execute();
$elections = $query->fetchAll();
$currentDate = new DateTime();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des Élections</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }

        .election-card {
            margin-bottom: 20px;
        }

        .election-card img {
            max-height: 200px;
            object-fit: cover;
        }

        .vote {
            width: 100px;
            /* Ajustez la taille selon vos besoins */
            height: auto;
            /* Conserve les proportions de l'image */
            position: absolute;
            top: 0px;
            /* Ajustez la distance du haut selon vos besoins */
            left: 0px;
            /* Ajustez la distance de la gauche selon vos besoins */
        }

        .vote img {
            max-height: 90px;
        }
        footer {
    background: #333;
    color: #fff;
    text-align: center;
    padding: 10px 0;
    position: relative;
    bottom: 0;
    width: 100%;
}
header {
    background: rgba(255, 255, 255, 0.8);
    padding: 30px 50px;
    display: flex;
    align-items: center;
    border-bottom: 2px solid #ccc;
    z-index: 1000; /* Ensure it is above other elements */
}
footer p {
    margin: 0;
}
    </style>
</head>

<body>
<header>
        <div class="vote">
            <a href="index.php">
                <img src="images/logo.png" alt="Voteum Logo" />
            </a>
        </div>
        </header>
    <div class="container">
    
        <h1 class="text-center mb-5">Liste des Élections</h1>
        <div class="row">
            <?php foreach ($elections as $election): ?>
                <div class="col-md-4">
                    <div class="card election-card">
                        <?php
                        $image_path = "http://localhost/gestion_vote/Front/view/images/" . htmlspecialchars($election['image']);
                        $startDate = new DateTime($election['start_date']);
                        $endDate = new DateTime($election['end_date']);
                        ?>
                        <?php if (file_exists($image_path)): ?>
                            <img class="card-img-top" src="<?php echo $image_path; ?>" alt="Image de l'élection">
                        <?php else: ?>
                            <img class="card-img-top" src="https://via.placeholder.com/200" alt="Image non disponible">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($election['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($election['description']); ?></p>
                            <p class="card-text"><small class="text-muted">Début:
                                    <?php echo htmlspecialchars($election['start_date']); ?></small></p>
                            <p class="card-text"><small class="text-muted">Fin:
                                    <?php echo htmlspecialchars($election['end_date']); ?></small></p>
                            <?php
                            // Assurez-vous que $currentDate, $startDate, et $endDate sont correctement initialisés
                            $currentDate = new DateTime();
                            $startDate = new DateTime($election['start_date']);
                            $endDate = new DateTime($election['end_date']);
                            ?>
                            <?php if ($currentDate >= $startDate && $currentDate <= $endDate): ?>
                                <a href="voter.php?id_election=<?php echo htmlspecialchars($election['id_election']); ?>"
                                    class="btn btn-primary">Voter</a>
                            <?php else: ?>
                                <a href="result.php?id_election=<?php echo htmlspecialchars($election['id_election']); ?>"
                                    class="btn btn-secondary">Voir les résultats</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>