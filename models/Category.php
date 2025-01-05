<?php
require_once dirname(__DIR__).'/config/Database.php'; // Inclusion de la configuration de la base de données

class Category {
    // Propriété pour stocker la connexion à la base de données
    private $conn;
    // Constructeur : initialise la connexion à la base de données
    public function __construct() {
        $database = new Database(); // Instancie la classe Database
        $this->conn = $database->getConnection(); // Récupère la connexion PDO
    } 

    // Récupère toutes les catégories
    public function getAll() {
        $query = "SELECT * FROM categories"; // Requête SQL pour récupérer toutes les catégories
        $stmt = $this->conn->prepare($query); // Préparation de la requête
        $stmt->execute(); // Exécution de la requête
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne toutes les catégories sous forme de tableau associatif
    }

    // Récupère une catégorie par son ID
    public function getById($id) {
        $query = "SELECT * FROM categories WHERE id = :id"; // Requête SQL pour récupérer une catégorie par son ID
        $stmt = $this->conn->prepare($query); // Préparation de la requête
        $stmt->execute([':id' => $id]); // Exécution de la requête avec l'ID en paramètre
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne la catégorie correspondante sous forme de tableau associatif
    }

    // Crée une nouvelle catégorie
    public function create($name, $description,$image)
    {
        $sql = "INSERT INTO categories (name, description,image) VALUES (:name, :description,:image)"; // Requête SQL pour insérer une nouvelle catégorie
        $stmt = $this->conn->prepare($sql); // Préparation de la requête

    // Liaison des paramètres
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);

        return $stmt->execute(); // Exécution de la requête, retourne true si l'insertion est réussie
    }

    // Met à jour une catégorie existante
    public function update($id, $name, $description,$image)
    {
        $sql = "UPDATE categories SET name = :name, description = :description ,image= :image WHERE id = :id"; // Requête SQL pour mettre à jour une catégorie
        $stmt = $this->conn->prepare($sql); // Préparation de la requête

    // Liaison des paramètres
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);

        return $stmt->execute(); // Exécution de la requête, retourne true si la mise à jour est réussie
    }

    // Supprime une catégorie
    public function delete($id)
    {
        $sql = "DELETE FROM categories WHERE id = :id"; // Requête SQL pour supprimer une catégorie par son ID
        $stmt = $this->conn->prepare($sql);  // Préparation de la requête

    // Liaison du paramètre
        $stmt->bindParam(':id', $id);

        return $stmt->execute(); // Exécution de la requête, retourne true si la suppression est réussie
    }

}
