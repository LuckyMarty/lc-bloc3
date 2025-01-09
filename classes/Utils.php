<?php
class Utils {
    public static function checkUserLoggedIn() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit();
        }
    }
}