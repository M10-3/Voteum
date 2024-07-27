<!DOCTYPE HTML>
<html>

<head>
    <title>Inscription</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />

    <script>
        // Récupérer la valeur de userType de l'URL
        var urlParams = new URLSearchParams(window.location.search);
        var userType = urlParams.get('userType');

        // Sélectionner le champ de formulaire hidden avec l'ID "userType"
        var userTypeField = document.getElementById('userType');

        // Assurez-vous que userTypeField existe et que la valeur de userType est définie
        if (userTypeField && userType) {
            // Assigner la valeur de userType au champ de formulaire hidden
            userTypeField.value = userType;
        }

    </script>

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

        /* Flouter l'image de fond */
        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('images/5.jpg') no-repeat center center fixed;
            background-size: cover;
            filter: blur(8px);
            /* Applique un effet de flou */
            z-index: -1;
            /* Place l'image derrière le contenu */
        }

        .container {
            position: relative;
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .form-wrapper {
            background: rgba(255, 255, 255, 0.9);
            /* Fond blanc semi-transparent */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="background"></div> <!-- Image de fond floutée -->
    <div class="container">
        <div class="form-wrapper">
            <h1>Se connecter</h1>
            <form action="http://localhost/gestion_vote/Front/controller/loginController.php" method="post">
                <label for="type">Choisissez le type :</label>
                <select id="userType" name="userType">
                    <option value="elector">électeur</option>
                    <option value="candidat">candidat</option>
                </select>
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
                
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit" value="S'inscrire" id="submitButton">Suivant</button>
            </form>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</html>