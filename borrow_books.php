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

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        .book-image {
            max-width: 100px;
            height: auto;
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

        .overdue {
            background-color: #ffcccc;
        }

        .legend {
            margin-top: 20px;
            padding: 10px;
            background-color: #e0e0e0;
            border-radius: 5px;
            display: flex;
            align-items: center;
        }

        .legend .dot {
            height: 10px;
            width: 10px;
            background-color: #FF0000;
            border-radius: 50%;
            display: inline-block;
            margin-right: 10px;
        }

        .legend span {
            font-size: 14px;
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

            .book-image {
                max-width: 50px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Liste des Emprunts - Librairie XYZ</h1>
    </header>

    <div class="container">
        <!-- Legend for overdue indicator -->
        <div class="legend">
            <div class="dot"></div>
            <span>Indique les livres en retard</span>
        </div>

        <!-- Affichage des emprunts depuis la base de données -->
        <?php
        require('config.php');
        require('classes/Emprunt.php');

        // Assuming user_id is stored in session
        $userId = $_SESSION['user_id'];

        $emprunt = new Emprunt($pdo);
        $emprunts = $emprunt->getEmpruntsByUserId($userId);

        if ($emprunts) {
            echo "<table>";
            echo "<tr><th>Image</th><th>Titre</th><th>Auteur</th><th>Date d'emprunt</th><th>Date de retour prévue</th><th>Date de retour effective</th><th>Actions</th></tr>";
            foreach ($emprunts as $row) {
                $isOverdue = strtotime($row['date_retour_effective']) < strtotime(date('Y-m-d'));
                $rowClass = $isOverdue ? 'overdue' : '';
                echo "<tr class='{$rowClass}'>";
                echo '<td><img class="book-image" src="' . htmlspecialchars($row['photo_url']) . '" alt="' . htmlspecialchars($row['titre']) . '"></td>';
                echo "<td>{$row['titre']}</td>";
                echo "<td>{$row['auteur']}</td>";
                echo "<td>{$row['date_emprunt']}</td>";
                echo "<td>{$row['date_retour_prevue']}</td>";
                echo "<td>{$row['date_retour_effective']}</td>";
                echo '<td><button onclick="returnBook(' . htmlspecialchars($row['id_emprunt']) . ')">Retourner le livre</button></td>';
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Aucun emprunt trouvé pour cet utilisateur.</p>";
        }
        ?>
        <button onclick="window.location.href = 'index.php'">Retour à l'accueil</button>
    </div>

    <script>
        function returnBook(empruntId) {
            if (confirm("Êtes-vous sûr de vouloir retourner ce livre ?")) {
                window.location.href = 'return_book.php?emprunt_id=' + empruntId;
            }
        }
    </script>
</body>
</html>