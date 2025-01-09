<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('config.php');
require('classes/Home.php');
require('classes/Emprunt.php');

// Start the session if it hasn't been started yet
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get the user ID from the session
$userId = $_SESSION['user_id'];

$emprunt = new Emprunt($pdo);
$emprunts = $emprunt->getEmpruntsByUserId($userId);

$overdueBooks = array_filter($emprunts, function($emprunt) {
    return strtotime($emprunt['date_retour_effective']) < strtotime(date('Y-m-d'));
});

$home = new Home($pdo);

// Récupérer le nombre total de livres
$resultTotalBooks = $home->getTotalBooks();

// Récupérer le nombre d'utilisateurs enregistrés
$resultTotalUsers = $home->getTotalUsers();

// Récupérer le nombre total d'emprunts
$resultTotalEmprunts = $home->getTotalEmprunts();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Accueil</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 1em 0;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: auto;
        }

        .message {
            margin-top: 20px;
            padding: 20px;
            background-color: #e0e0e0;
            border-radius: 5px;
            text-align: center;
        }

        .statistic {
            margin-top: 20px;
            padding: 20px;
            background-color: #e0e0e0;
            border-radius: 5px;
            text-align: center;
        }

        button {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<header>
    <h1>Librairie XYZ</h1>
</header>

<div class="wrapper">
    <!-- Sidebar -->
    <nav id="sidebar">
        <ul>
            <?php if (isset($_SESSION['user'])) : ?>
                <li>Bonjour <?= $_SESSION['prenom']; ?></li>
                <li><a href="books.php">Voir la liste des livres</a></li>
                <li><a href="profile.php">Mon profil</a></li>
                <li><a href="borrow_books.php">Mes emprunts</a></li>
                <li><a href="logout.php">Deconnexion</a></li>
            <?php else : ?>
                <li><a href="login.php">Connexion</a></li>
                <li><a href="register.php">Inscription</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Page Content -->
    <div id="content">
        <div class="container">
            <?php if (!empty($overdueBooks)): ?>
                <div class="message">
                    Attention ! Vous avez des livres empruntés depuis plus de 30 jours.
                </div>
            <?php endif; ?>

            <!-- Votre contenu principal va ici -->
            <div id="content">
                <h1>Dashboard</h1>
                <div class="container">
                    <div class="statistic">
                        <h3>Total des Livres</h3>
                        <p><?php echo $resultTotalBooks['total_books']; ?></p>
                    </div>

                    <div class="statistic">
                        <h3>Utilisateurs Enregistrés</h3>
                        <p><?php echo $resultTotalUsers['total_users']; ?></p>
                    </div>

                    <div class="statistic">
                        <h3>Total des Emprunts</h3>
                        <p><?php echo $resultTotalEmprunts['total_emprunts']; ?></p>
                    </div>

                    <!-- ... Autres statistiques ... -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    <div class="container">
        <p>&copy; <?= date("Y"); ?> Librairie XYZ</p>
    </div>
</footer>
</body>
</html>