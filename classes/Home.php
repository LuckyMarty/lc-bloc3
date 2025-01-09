<?php
require(__DIR__ . '/../config.php');

class Home {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getTotalBooks() {
        $query = "SELECT COUNT(*) as total_books FROM livres";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTotalUsers() {
        $query = "SELECT COUNT(*) as total_users FROM utilisateurs";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTotalEmprunts() {
        $query = "SELECT COUNT(*) as total_emprunts FROM emprunts";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}