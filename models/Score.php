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
        $sql = "SELECT * FROM scores WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateScore($userId, $score, $quiz_id, $total_correct_questions)
    {
        $sql = "UPDATE scores SET score = :score, total_correct_questions = :total_correct_questions, played_at = NOW() WHERE user_id = :user_id AND quiz_id = :quiz_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':score', $score);
        $stmt->bindParam(':quiz_id', $quiz_id);
        $stmt->bindParam(':total_correct_questions', $total_correct_questions);
        
        return $stmt->execute();
    }

    public function saveScore($userId, $score, $quiz_id, $total_correct_questions)
    {
        $sql = "INSERT INTO scores (user_id, score, quiz_id,total_correct_questions, played_at) VALUES (:user_id, :score,:quiz_id, :total_correct_questions, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':score', $score);
        $stmt->bindParam(':quiz_id', $quiz_id);
        $stmt->bindParam(':total_correct_questions', $total_correct_questions);
        
        return $stmt->execute();
    }
}
