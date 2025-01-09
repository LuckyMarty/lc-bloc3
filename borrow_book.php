<?php
require('config.php');
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

// Get the book ID from the query parameter
$bookId = isset($_GET['book_id']) ? intval($_GET['book_id']) : 0;

// Get the user ID from the session
$userId = $_SESSION['user_id'];

// Check if the book ID is valid
if ($bookId > 0) {
    $emprunt = new Emprunt($pdo);

    // Check if the book is available
    if ($emprunt->isBookAvailable($bookId)) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the return date from the form
            $dateRetourPrevue = isset($_POST['date_retour']) ? $_POST['date_retour'] : '';

            // Validate the return date
            if (strtotime($dateRetourPrevue) > strtotime(date('Y-m-d')) && strtotime($dateRetourPrevue) <= strtotime('+30 days')) {
                // Create a new emprunt
                $dateEmprunt = date('Y-m-d');
                $emprunt->createEmprunt($userId, $bookId, $dateEmprunt, $dateRetourPrevue);

                // Update the book status to 'emprunté'
                $emprunt->updateBookStatus($bookId, 'emprunté');

                echo "Le livre a été emprunté avec succès.";
            } else {
                echo "La date de retour doit être comprise entre aujourd'hui et 30 jours à partir d'aujourd'hui.";
            }
        } else {
            // Display the form to specify the return date
            $maxDate = date('Y-m-d', strtotime('+30 days'));
            ?>
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <title>Emprunter un Livre - Librairie XYZ</title>
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

                    form {
                        margin-top: 20px;
                    }

                    label, input, button {
                        display: block;
                        margin: 10px 0;
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
            </head>
            <body>
                <header>
                    <h1>Emprunter un Livre - Librairie XYZ</h1>
                </header>
                <div class="container">
                    <form method="post">
                        <label for="date_retour">Date de retour :</label>
                        <input type="date" id="date_retour" name="date_retour" required max="<?= $maxDate ?>">
                        <button type="submit">Emprunter le livre</button>
                    </form>
                    <button onclick="window.location.href = 'books.php'">Retour à la liste des livres</button>
                </div>
            </body>
            </html>
            <?php
        }
    } else {
        echo "Le livre n'est pas disponible pour emprunt.";
    }
} else {
    echo "ID de livre invalide.";
}
?>