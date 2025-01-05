<?php
require_once dirname(__DIR__) . '/config/Database.php'; // Inclusion de la configuration de la base de données

class Score
{
    // Propriété pour stocker la connexion à la base de données
    private $conn;

    // Constructeur : initialise la connexion à la base de données
    public function __construct() {
        $database = new Database();                 // Instancie la classe Database
        $this->conn = $database->getConnection();   // Récupère la connexion PDO
    }

    // Méthode pour récupérer les scores d'un utilisateur spécifique
    public function getByUserId($userId) {
        // Requête SQL pour récupérer tous les scores associés à un utilisateur
        $sql = "SELECT * FROM scores WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($sql);        // Préparation de la requête SQL
        $stmt->bindParam(':user_id', $userId);     // Liaison du paramètre `user_id`
        $stmt->execute();                          // Exécution de la requête

        // Retourne tous les scores sous forme de tableau associatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour mettre à jour un score existant
    public function updateScore($userId, $score, $quiz_id, $total_correct_questions) {
        // Requête SQL pour mettre à jour le score, le nombre de bonnes réponses, et la date du jeu
        $sql = "UPDATE scores 
                SET score = :score, 
                    total_correct_questions = :total_correct_questions, 
                    played_at = NOW() 
                WHERE user_id = :user_id 
                AND quiz_id = :quiz_id";
        $stmt = $this->conn->prepare($sql);        // Préparation de la requête SQL

        // Liaison des paramètres
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':score', $score);
        $stmt->bindParam(':quiz_id', $quiz_id);
        $stmt->bindParam(':total_correct_questions', $total_correct_questions);

        // Exécution de la requête, retourne true si la mise à jour est réussie
        return $stmt->execute();
    }

    // Méthode pour enregistrer un nouveau score
    public function saveScore($userId, $score, $quiz_id, $total_correct_questions) {
        // Requête SQL pour insérer un nouveau score dans la table `scores`
        $sql = "INSERT INTO scores 
                (user_id, score, quiz_id, total_correct_questions, played_at) 
                VALUES (:user_id, :score, :quiz_id, :total_correct_questions, NOW())";
        $stmt = $this->conn->prepare($sql);        // Préparation de la requête SQL

        // Liaison des paramètres
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':score', $score);
        $stmt->bindParam(':quiz_id', $quiz_id);
        $stmt->bindParam(':total_correct_questions', $total_correct_questions);

        // Exécution de la requête, retourne true si l'insertion est réussie
        return $stmt->execute();
    }
}
