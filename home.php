<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('config.php');

require('classes/Home.php');

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
            <li><a href="emprunts.php">Mes emprunts</a></li>
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