<?php
class Emprunt
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllEmprunts()
    {
        $query = "SELECT * FROM emprunts";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEmpruntById($id)
    {
        $query = "SELECT * FROM emprunts WHERE id_emprunt = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getEmpruntsByUserId($userId)
    {
        $query = "
            SELECT emprunts.*, livres.titre, livres.auteur, livres.photo_url 
            FROM emprunts 
            JOIN livres ON emprunts.id_livre = livres.id 
            WHERE emprunts.id_utilisateur = :id_utilisateur
        ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_utilisateur', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createEmprunt($userId, $bookId, $dateEmprunt, $dateRetourPrevue)
    {
        $dateRetourEffective = date('Y-m-d', strtotime($dateEmprunt . ' + 30 days'));
        $query = "INSERT INTO emprunts (id_utilisateur, id_livre, date_emprunt, date_retour_prevue, date_retour_effective) VALUES (:id_utilisateur, :book_id, :date_emprunt, :date_retour_prevue, :date_retour_effective)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_utilisateur', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->bindParam(':date_emprunt', $dateEmprunt);
        $stmt->bindParam(':date_retour_prevue', $dateRetourPrevue);
        $stmt->bindParam(':date_retour_effective', $dateRetourEffective);
        return $stmt->execute();
    }

    public function updateBookStatus($bookId, $status)
    {
        $query = "UPDATE livres SET statut = :status WHERE id = :book_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        return $stmt->execute();
    }


    public function updateEmprunt($id, $dateRetour)
    {
        $query = "UPDATE emprunts SET date_retour_prevue = :date_retour WHERE id_emprunt = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':date_retour', $dateRetour);
        return $stmt->execute();
    }

    public function isBookAvailable($bookId)
    {
        $query = "SELECT statut FROM livres WHERE id = :book_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->execute();
        $book = $stmt->fetch(PDO::FETCH_ASSOC);
        return $book && $book['statut'] === 'disponible';
    }



    public function updateBookStatusByEmpruntId($empruntId, $status)
    {
        $query = "
        UPDATE livres 
        SET statut = :status 
        WHERE id = (SELECT id_livre FROM emprunts WHERE id_emprunt = :emprunt_id)
    ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':emprunt_id', $empruntId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteEmprunt($id)
    {
        $query = "DELETE FROM emprunts WHERE id_emprunt = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
