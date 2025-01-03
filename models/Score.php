<?php
require_once dirname(__DIR__).'/config/Database.php';

class Score
{
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getByUserId($userId)
    {
        $sql = "SELECT score, total_questions, played_at FROM scores WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveScore($userId, $score, $totalQuestions)
    {
        $sql = "INSERT INTO scores (user_id, score, total_questions, played_at) VALUES (:user_id, :score, :total_questions, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':score', $score);
        $stmt->bindParam(':total_questions', $totalQuestions);
        
        return $stmt->execute();
    }
}
