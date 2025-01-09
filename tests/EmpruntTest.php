<?php
require_once(__DIR__ . '/../classes/Emprunt.php');

use PHPUnit\Framework\TestCase;

class EmpruntTest extends TestCase
{
    private $pdo;
    private $emprunt;

    protected function setUp(): void
    {
        // Create a mock for the PDO class.
        $this->pdo = $this->createMock(PDO::class);

        // Create an instance of the Emprunt class with the mocked PDO.
        $this->emprunt = new Emprunt($this->pdo);
    }

    public function testIsBookAvailable()
    {
        // Create a mock for the PDOStatement class.
        $stmt = $this->createMock(PDOStatement::class);

        // Configure the PDO mock to return the PDOStatement mock.
        $this->pdo->method('prepare')
            ->willReturn($stmt);

        // Configure the PDOStatement mock to return a specific result when fetch is called.
        $stmt->method('fetch')
            ->willReturn(['statut' => 'disponible']);

        // Call the method to test.
        $bookId = 1;
        $result = $this->emprunt->isBookAvailable($bookId);

        // Assert that the result is true.
        $this->assertTrue($result);
    }

    public function testCreateEmprunt()
    {
        // Create a mock for the PDOStatement class.
        $stmt = $this->createMock(PDOStatement::class);

        // Configure the PDO mock to return the PDOStatement mock.
        $this->pdo->method('prepare')
            ->willReturn($stmt);

        // Configure the PDOStatement mock to return true when execute is called.
        $stmt->method('execute')
            ->willReturn(true);

        // Call the method to test.
        $userId = 1;
        $bookId = 1;
        $dateEmprunt = date('Y-m-d');
        $dateRetourPrevue = date('Y-m-d', strtotime('+14 days'));

        $result = $this->emprunt->createEmprunt($userId, $bookId, $dateEmprunt, $dateRetourPrevue);

        // Assert that the result is true.
        $this->assertTrue($result);
    }



    public function testUpdateBookStatus()
    {
        // Create a mock for the PDOStatement class.
        $stmt = $this->createMock(PDOStatement::class);

        // Configure the PDO mock to return the PDOStatement mock.
        $this->pdo->method('prepare')
            ->willReturn($stmt);

        // Configure the PDOStatement mock to return true when execute is called.
        $stmt->method('execute')
            ->willReturn(true);

        // Call the method to test.
        $bookId = 1;
        $status = 'emprunté';
        $result = $this->emprunt->updateBookStatus($bookId, $status);

        // Assert that the result is true.
        $this->assertTrue($result);
    }

    public function testIsBookUnvailable()
    {
        // Create a mock for the PDOStatement class.
        $stmt = $this->createMock(PDOStatement::class);

        // Configure the PDO mock to return the PDOStatement mock.
        $this->pdo->method('prepare')
            ->willReturn($stmt);

        // Configure the PDOStatement mock to return a specific result when fetch is called.
        $stmt->method('fetch')
            ->willReturn(['statut' => 'emprunté']);

        // Call the method to test.
        $bookId = 1;
        $result = $this->emprunt->isBookAvailable($bookId);

        // Assert that the result is false.
        $this->assertFalse($result);
    }

    public function testReturnBookUpdateStatus()
    {
        // Create a mock for the PDOStatement class.
        $stmt = $this->createMock(PDOStatement::class);

        // Configure the PDO mock to return the PDOStatement mock.
        $this->pdo->method('prepare')
            ->willReturn($stmt);

        // Configure the PDOStatement mock to return true when execute is called.
        $stmt->method('execute')
            ->willReturn(true);

        // Call the method to test.
        $empruntId = 1;
        $status = 'disponible';
        $result = $this->emprunt->updateBookStatusByEmpruntId($empruntId, $status);

        // Assert that the result is true.
        $this->assertTrue($result);
    }

    public function testDeleteEmprunt()
    {
        // Create a mock for the PDOStatement class.
        $stmt = $this->createMock(PDOStatement::class);

        // Configure the PDO mock to return the PDOStatement mock.
        $this->pdo->method('prepare')
            ->willReturn($stmt);

        // Configure the PDOStatement mock to return true when execute is called.
        $stmt->method('execute')
            ->willReturn(true);

        // Call the method to test.
        $empruntId = 1;
        $result = $this->emprunt->deleteEmprunt($empruntId);

        // Assert that the result is true.
        $this->assertTrue($result);
    }

    public function testCheckReturnBookAvailable()
    {
        // Create a mock for the PDOStatement class.
        $stmt = $this->createMock(PDOStatement::class);

        // Configure the PDO mock to return the PDOStatement mock.
        $this->pdo->method('prepare')
            ->willReturn($stmt);

        // Configure the PDOStatement mock to return a specific result when fetch is called.
        $stmt->method('fetch')
            ->willReturn(['statut' => 'emprunté']);

        // Call the method to test.
        $empruntId = 1;
        $result = $this->emprunt->isBookAvailable($empruntId);

        // Assert that the result is false.
        $this->assertFalse($result);
    }
}
