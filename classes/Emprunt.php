<?php
class Emprunt {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllEmprunts() {
        $query = "SELECT * FROM emprunts";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEmpruntById($id) {
        $query = "SELECT * FROM emprunts WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getEmpruntsByUserId($userId) {
        $query = "SELECT * FROM emprunts WHERE id_utilisateur = :id_utilisateur";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_utilisateur', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createEmprunt($userId, $bookId, $dateEmprunt, $dateRetour) {
        $query = "INSERT INTO emprunts (id_utilisateur, book_id, date_emprunt, date_retour) VALUES (:id_utilisateur, :book_id, :date_emprunt, :date_retour)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_utilisateur', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->bindParam(':date_emprunt', $dateEmprunt);
        $stmt->bindParam(':date_retour', $dateRetour);
        return $stmt->execute();
    }

    public function updateEmprunt($id, $dateRetour) {
        $query = "UPDATE emprunts SET date_retour = :date_retour WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':date_retour', $dateRetour);
        return $stmt->execute();
    }

    public function deleteEmprunt($id) {
        $query = "DELETE FROM emprunts WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}