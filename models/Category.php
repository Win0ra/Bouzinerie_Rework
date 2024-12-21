<?php
require_once dirname(__DIR__).'/config/Database.php';

class Category {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT * FROM categories";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM categories WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function create($name, $description)
    {
        $sql = "INSERT INTO categories (name, description) VALUES (:name, :description)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);

        return $stmt->execute();
    }

    // Update an existing category
    public function update($id, $name, $description)
    {
        $sql = "UPDATE categories SET name = :name, description = :description WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);

        return $stmt->execute();
    }

    // Delete a category
    public function delete($id)
    {
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

}
