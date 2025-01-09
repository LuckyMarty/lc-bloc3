<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}



include("config.php");
// include("header.php");

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'login':
        echo "Avant inclusion du login.php"; // Débogage
        include("login.php");
        echo "Après inclusion du login.php"; // Débogage
        break;
    case 'books':
        include("books.php");
        break;
    case 'emprunts':
        include("emprunts.php");
        break;
    case 'book_details':
        include("book_details.php");
        break;
    case 'borrow_book':
        include("borrow_book.php");
        break;
    default:
        include("home.php");
        break;
}

include("footer.php");
?>
