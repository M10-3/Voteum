<?php
session_start();
require_once '../view/functions.php';
is_connect();
include_once "../config.php";
require_once '../controller/UsersC.php';

$notificationController = new NotificationC();
$notification = $notificationController->getMessage($_SESSION['userId']);
$notif = end($notification);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Profile Management</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header img {
            height: 40px;
        }

        .notification-button {
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 24px;
            position: relative;
        }

        .notification-button .fa-bell {
            color: #afd3eb;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 600px;
        }

        .modal-content .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .modal-content .close:hover {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .form-container {
            background-color: whitesmoke;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h3 {
            text-align: center;
            color: #3498db;
        }

        .form-container .form-group {
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            font-weight: bold;
            font-size: 1.2em;
            margin-bottom: 5px;
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"],
        .form-container input[type="date"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 0 auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-container input[type="submit"],
        .form-container .delete-account-button {
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 15px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: block;
            margin: 0 auto;
        }

        .form-container input[type="submit"]:hover,
        .form-container .delete-account-button:hover {
            background-color: #2980b9;
        }

        .form-container .delete-account-button {
            background-color: #e74c3c;
        }

        .form-container .delete-account-button:hover {
            background-color: #c0392b;
        }

        .footer {
            text-align: center;
            padding: 20px;
            background-color: #000;
            color: #fff;
        }

        .error-message {
            color: red;
            font-size: 0.9em;
        }
    </style>
    <script>
        function openModal() {
            document.getElementById('myModal').style.display = 'block';
        }
        function closeModal() {
            document.getElementById('myModal').style.display = 'none';
        }
        window.onclick = function (event) {
            if (event.target == document.getElementById('myModal')) {
                closeModal();
            }
        }
    </script>
</head>

<body>
    <header class="header">
        <a href="http://localhost/gestion_vote/Front/view/index.php"><img src="images/logo.png" alt="Voteum Logo" /></a>
        <button id="notificationButton" class="notification-button" onclick="openModal()">
            <i class="fas fa-bell"></i>
        </button>
    </header>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="notifications">
                <?php foreach ($notification as $notif): ?>
                    <div>
                        <?php echo $notif["message"]; ?>
                        <form action="http://localhost/gestion_vote/Front/view/notif_read.php" method="post">
                            <input type="hidden" name="notification_id" value="<?php echo $notif['userId']; ?>">
                            <button type="submit">Marquer comme lu</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="container">
        <center>
            <h2>My Profile</h2>
        </center>

        <div class="form-container">
            <h3>Username</h3>
            <form id="usernameForm" action="http://localhost/gestion_vote/Front/controller/UpdateUsers.php"
                method="post">
                <div class="form-group">
                    <label for="actualUsername">Actuel Username:</label>
                    <input type="text" name="actualUsername" id="actualUsername"
                        placeholder="<?php echo $_SESSION['username']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="newUsername">New Username:</label>
                    <input type="text" name="newUsername" id="newUsername" placeholder="New Username">
                </div>
                <span id="error_newUserName" class="error-message"></span>
                <input type="submit" value="Change My Username">
            </form>
        </div>

        <div class="form-container">
            <h3>Full Name</h3>
            <form id="full_nameForm" action="http://localhost/gestion_vote/Front/controller/UpdateUsers.php"
                method="post">
                <div class="form-group">
                    <label for="actualFull_name">Actual Full Name:</label>
                    <input type="text" name="actualFull_name" id="actualFull_name"
                        placeholder="<?php echo $_SESSION['full_name']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="newFull_name">New Full Name:</label>
                    <input type="text" name="newFull_name" id="newFull_name" placeholder="New Full Name">
                </div>
                <span id="error_newFull_name" class="error-message"></span>
                <input type="submit" value="Change My Full Name">
            </form>
        </div>

        <div class="form-container">
            <h3>Email</h3>
            <form id="emailForm" action="http://localhost/gestion_vote/Front/controller/UpdateUsers.php" method="post">
                <div class="form-group">
                    <label for="actualEmail">Actual Email:</label>
                    <input type="email" name="actualEmail" id="actualEmail"
                        placeholder="<?php echo $_SESSION['email']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="newEmail">New Email:</label>
                    <input type="email" name="newEmail" id="newEmail" placeholder="New Email">
                </div>
                <span id="error_newEmail" class="error-message"></span>
                <input type="submit" value="Change My Email">
            </form>
        </div>

        <!-- Date of Birth -->
        <div class="form-container">
            <h3>Date of Birth</h3>
            <form id="dobForm" action="http://localhost/gestion_vote/Front/controller/UpdateUsers.php" method="post">
                <div class="form-group">
                    <label for="actualDob">Actual DOB:</label>
                    <input type="date" name="actualDob" id="actualDob" value="<?php echo $_SESSION['dob']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="newDob">New DOB:</label>
                    <input type="date" name="newDob" id="newDob" placeholder="New DOB">
                </div>
                <span id="error_newDob" class="error-message"></span>
                <input type="submit" value="Change My DOB">
            </form>
        </div>

        <!-- Address -->
        <div class="form-container">
            <h3>Address</h3>
            <form id="adresseForm" action="http://localhost/gestion_vote/Front/controller/UpdateUsers.php"
                method="post">
                <div class="form-group">
                    <label for="actualAdresse">Actual Address:</label>
                    <input type="text" name="actualAdresse" id="actualAdresse"
                        value="<?php echo $_SESSION['adresse']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="newAdresse">New Address:</label>
                    <input type="text" name="newAdresse" id="newAdresse" placeholder="New Address">
                </div>
                <span id="error_newAdresse" class="error-message"></span>
                <input type="submit" value="Change My Address">
            </form>
        </div>


        <div class="form-container">
            <h3>Password</h3>
            <form id="passwordForm" action="http://localhost/gestion_vote/Front/controller/UpdateUsers.php"
                method="post">
                <div class="form-group">
                    <label for="actualPassword">Current Password:</label>
                    <input type="password" name="actualPassword" id="actualPassword" placeholder="Current Password">
                </div>
                <div class="form-group">
                    <label for="newPassword">New Password:</label>
                    <input type="password" name="newPassword" id="newPassword" placeholder="New Password">
                </div>
                <span id="error_newPassword" class="error-message"></span>
                <input type="submit" value="Change My Password">
            </form>
        </div>

        <div class="form-container">
            <h3>Delete My Account</h3>
            <form id="deleteAccountForm" action="http://localhost/gestion_vote/Front/controller/DeleteUsers.php"
                method="post">
                <input type="hidden" name="actualEmail" id="actualEmail" placeholder="<?php echo $_SESSION['email']; ?>"
                    readonly>
                <input type="submit" value="Delete My Account" class="delete-account-button">
            </form>
        </div>
    </div>

    <footer class="footer">
        &copy; Voteum, Tous droits réservés.
    </footer>
</body>

</html>