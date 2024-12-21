

<?php
require_once  dirname(__DIR__).'/config/Database.php';

class Question {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT * FROM questions";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByCategory($categoryId) {
        $query = "SELECT * FROM questions WHERE category_id = :category_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':category_id' => $categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM questions WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function create($question, $answers, $correct_answer, $category_id)
    {
        $sql = "INSERT INTO questions (question, answers, correct_answer, category_id) 
                VALUES (:question, :answers, :correct_answer, :category_id)";
        $stmt = $this->conn->prepare($sql);
    
        $encodedAnswers = json_encode($answers); 
    
        $stmt->bindParam(':question', $question);
        $stmt->bindParam(':answers', $encodedAnswers);
        $stmt->bindParam(':correct_answer', $correct_answer);
        $stmt->bindParam(':category_id', $category_id);
    
        return $stmt->execute();
    }
    

    // Update an existing question
    public function update($id, $question, $answers, $correct_answer, $category_id)
    {
        $sql = "UPDATE questions 
                SET question = :question, answers = :answers, correct_answer = :correct_answer, category_id = :category_id 
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':question', $question);
        $stmt->bindParam(':answers', json_encode($answers)); // Store as JSON
        $stmt->bindParam(':correct_answer', $correct_answer);
        $stmt->bindParam(':category_id', $category_id);

        return $stmt->execute();
    }

    // Delete a question
    public function delete($id)
    {
        $sql = "DELETE FROM questions WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

}

