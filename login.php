<?php
require('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate email
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email invalide";
    } else {
        $password = $_POST['password'];

        // Requête pour récupérer l'utilisateur par son email
        $query = "SELECT id, mot_de_passe, prenom, role FROM utilisateurs WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(':email' => $email));
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['mot_de_passe'])) {
            // Mot de passe correct, connecter l'utilisateur
            session_start();
            session_regenerate_id(true); // Regenerate session ID to prevent session fixation
            $_SESSION['user'] = $email;
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_id'] = $user['id'];
            header('Location: index.php'); // Rediriger vers la page d'accueil
            exit();
        } else {
            $error = "Email ou mot de passe incorrect";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Librairie XYZ</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self'; style-src 'self';">
</head>
<body>
<header>
    <h1>Connexion - Librairie XYZ</h1>
</header>
<form method="post" action="">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <button type="submit">Se connecter</button>
    <p>Vous n'avez pas de compte ? <a href="register.php">S'inscrire</a></p>
</form>
<?php if (isset($error)) { echo "<p>" . htmlspecialchars($error) . "</p>"; } ?>
</body>
</html>

