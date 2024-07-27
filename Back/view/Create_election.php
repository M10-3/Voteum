<?php
session_start();
require_once '../config.php'; // Assurez-vous que ce fichier est bien inclus
require_once '../view/functions.php'; // Assurez-vous que ce fichier est bien inclus

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Vérification de l'existence du fichier
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_error = $_FILES['image']['error'];
        $image_type = $_FILES['image']['type'];

        // Validation des données
        if (empty($title) || empty($description) || empty($start_date) || empty($end_date)) {
            $_SESSION['flash']['danger'] = "Tous les champs doivent être remplis.";
        } else {
            // Déplacer le fichier téléchargé vers le répertoire de destination
            $upload_dir = '../uploads/'; // Répertoire où vous souhaitez stocker les images
            $upload_file = $upload_dir . basename($image_name);

            // Vérifiez que le répertoire d'upload existe
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            if (move_uploaded_file($image_tmp_name, $upload_file)) {
                // Connexion à la base de données
                $pdo = config::getConnexion();

                // Insertion des données dans la base de données
                $query = "INSERT INTO election (title, image, description, start_date, end_date) VALUES (:title, :image, :description, :start_date, :end_date)";
                $stmt = $pdo->prepare($query);
                $stmt->execute([
                    'title' => $title,
                    'image' => $image_name, // Utilisez le nom du fichier téléchargé
                    'description' => $description,
                    'start_date' => $start_date,
                    'end_date' => $end_date
                ]);
                $id_election = $pdo->lastInsertId();

                $_SESSION['flash']['success'] = "L'élection a été créée avec succès.";
                header("Location: ../view/ReadUsers.php"); // Redirigez vers une page de confirmation ou de gestion des élections
                exit();
            } else {
                $_SESSION['flash']['danger'] = "Erreur lors du téléchargement de l'image.";
            }
        }
    } else {
        $_SESSION['flash']['danger'] = "Veuillez télécharger une image valide.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <title>Créer une Élection</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            overflow: hidden;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('images/5.jpg') no-repeat center center fixed;
            background-size: cover;
            filter: blur(8px);
            z-index: -1;
        }

        .container {
            position: relative;
            width: 100%;
            max-width: 400px;
            padding: 20px;
            box-sizing: border-box;
        }

        .form-wrapper {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        input,
        button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background: #3498db;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #2980b9;
        }

        .form-group {
            width: 100%;
            margin-bottom: 10px;
        }

        .form-group label {
            display: block;
            margin-bottom: 0px;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        textarea {
            max-width: 100%;
        }

        textarea {
            resize: vertical; /* Permet le redimensionnement vertical des zones de texte */
        }
    </style>
</head>
<body>
    <div class="background"></div>
    <div class="container">
        <div class="form-wrapper">
            <h1>Créer une Élection</h1>
            <?php if (isset($_SESSION['flash']['danger'])): ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION['flash']['danger']; ?>
                    <?php unset($_SESSION['flash']['danger']); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['flash']['success'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['flash']['success']; ?>
                    <?php unset($_SESSION['flash']['success']); ?>
                </div>
            <?php endif; ?>
            <form action="Create_election.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Titre de l'Élection :</label>
                    <input type="text" id="title" name="title" placeholder="Titre de l'élection" required>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image" accept="image/*" required />
                </div>

                <div class="form-group">
                    <label for="description">Description :</label>
                    <textarea id="description" name="description" rows="4" placeholder="Description de l'élection" required></textarea>
                </div>

                <div class="form-group">
                    <label for="start_date">Date de Début :</label>
                    <input type="date" id="start_date" name="start_date" required>
                </div>

                <div class="form-group">
                    <label for="end_date">Date de Fin :</label>
                    <input type="date" id="end_date" name="end_date" required>
                </div>

                <button type="submit">Créer l'Élection</button>
            </form>
        </div>
    </div>
</body>
</html>

