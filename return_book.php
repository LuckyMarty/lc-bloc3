<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('config.php');
require('classes/Emprunt.php');

// Get the emprunt ID from the query parameter
$empruntId = isset($_GET['emprunt_id']) ? intval($_GET['emprunt_id']) : 0;

// Check if the emprunt ID is valid
if ($empruntId > 0) {
    $emprunt = new Emprunt($pdo);

    // Update the emprunt to set the return date and update the book status
    $dateRetourEffective = date('Y-m-d');
    $emprunt->updateEmprunt($empruntId, $dateRetourEffective);
    $emprunt->updateBookStatusByEmpruntId($empruntId, 'disponible');
    $emprunt->deleteEmprunt($empruntId);

    $message = "Le livre a été retourné avec succès.";
} else {
    $message = "ID d'emprunt invalide.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Retourner un Livre - Librairie XYZ</title>
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
        <h1>Retourner un Livre - Librairie XYZ</h1>
    </header>
    <div class="container">
        <div class="message">
            <?= htmlspecialchars($message) ?>
        </div>
        <button onclick="window.location.href = 'borrow_books.php'">Retour à la liste des emprunts</button>
    </div>
</body>
</html>