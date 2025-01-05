<?php
require_once  dirname(__DIR__).'/config/Database.php'; // Inclusion de la configuration de la base de données

class Question {
    // Propriété pour stocker la connexion à la base de données
    private $conn;

// Constructeur : initialise la connexion à la base de données
    public function __construct() {
        $database = new Database(); // Instancie la classe Database
        $this->conn = $database->getConnection(); // Récupère la connexion PDO
    }

    public function getAll() {
        $query = "SELECT * FROM questions"; // Requête SQL pour récupérer toutes les questions
        $stmt = $this->conn->prepare($query); // Préparation de la requête
        $stmt->execute(); // Exécution de la requête
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne toutes les questions sous forme de tableau associatif
    }

    // Récupère toutes les questions associées à une catégorie spécifique
    public function getByCategory($categoryId) {
        $query = "SELECT * FROM questions WHERE category_id = :category_id"; // Requête SQL pour récupérer les questions par catégorie
        $stmt = $this->conn->prepare($query); // Préparation de la requête
        $stmt->execute([':category_id' => $categoryId]); // Exécution de la requête avec l'ID de catégorie en paramètre
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne les questions correspondantes sous forme de tableau associatif
    }

    // Récupère une question spécifique par son ID
    public function getById($id) {
        $query = "SELECT * FROM questions WHERE id = :id"; // Requête SQL pour récupérer une question par son ID
        $stmt = $this->conn->prepare($query); // Préparation de la requête
        $stmt->execute([':id' => $id]); // Exécution de la requête avec l'ID en paramètre
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne la question correspondante sous forme de tableau associatif
    }
    // Crée une nouvelle question
    public function create($question, $answers, $correct_answer, $category_id)
    {
        $sql = "INSERT INTO questions (question, answers, correct_answer, category_id) 
                VALUES (:question, :answers, :correct_answer, :category_id)"; // Requête SQL pour insérer une nouvelle question
        $stmt = $this->conn->prepare($sql); // Préparation de la requête
    
        $encodedAnswers = $answers; 
    
        $stmt->bindParam(':question', $question);
        $stmt->bindParam(':answers', $encodedAnswers); // Les réponses sont stockées sous forme JSON
        $stmt->bindParam(':correct_answer', $correct_answer);
        $stmt->bindParam(':category_id', $category_id);
    
        return $stmt->execute(); // Exécution de la requête, retourne true si l'insertion est réussie
    }
    

    // Met à jour une question existante
    public function update($id, $question, $answers, $correct_answer, $category_id)
    {
        $sql = "UPDATE questions 
                SET question = :question, answers = :answers, correct_answer = :correct_answer, category_id = :category_id 
                WHERE id = :id"; // Requête SQL pour mettre à jour une question existante
        $stmt = $this->conn->prepare($sql); // Préparation de la requête
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':question', $question);
        $stmt->bindParam(':answers', $answers); // // Les réponses sont stockées sous forme JSON
        $stmt->bindParam(':correct_answer', $correct_answer);
        $stmt->bindParam(':category_id', $category_id);

        return $stmt->execute(); // Exécution de la requête, retourne true si la mise à jour est réussie
    }

    // Supprime une question par son ID
    public function delete($id)
    {
        $sql = "DELETE FROM questions WHERE id = :id"; // Requête SQL pour supprimer une question par son ID
        $stmt = $this->conn->prepare($sql); // Préparation de la requête

        $stmt->bindParam(':id', $id);

        return $stmt->execute(); // Exécution de la requête, retourne true si la suppression est réussie
    }

}

