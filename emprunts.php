<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('classes/Utils.php');
Utils::checkUserLoggedIn();

require('config.php');
require('classes/Emprunt.php');

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des Emprunts - Librairie XYZ</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        button {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>

    <!-- Ajoutez des médias requêtes pour le style responsive -->
    <style>
        @media (max-width: 768px) {
            .container {
                width: 100%;
            }

            table {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <header>
        <h1>Liste des Emprunts - Librairie XYZ</h1>
    </header>

    <div class="container">
        <!-- Affichage des emprunts depuis la base de données -->
        <?php


        // Assuming user_id is stored in session
        $userId = $_SESSION['user_id'];

        $emprunt = new Emprunt($pdo);
        $emprunts = $emprunt->getEmpruntsByUserId($userId);

        if ($emprunts) {
            echo "<table>";
            echo "<tr><th>ID</th><th>ID Utilisateur</th><th>ID Livre</th><th>Date d'emprunt</th><th>Date de retour</th><th>Statut</th></tr>";
            foreach ($emprunts as $row) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['user_id']}</td>";
                echo "<td>{$row['book_id']}</td>";
                echo "<td>{$row['date_emprunt']}</td>";
                echo "<td>{$row['date_retour']}</td>";
                echo "<td>{$row['statut']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Aucun emprunt trouvé pour cet utilisateur.</p>";
        }
        ?>
        <button onclick="window.location.href = 'index.php'">Retour à l'accueil</button>
    </div>
</body>

</html>