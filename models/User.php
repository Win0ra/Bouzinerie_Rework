<?php
require_once dirname(__DIR__). '/config/Database.php';

class User {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create($email, $password,$pseudo) {
        try {
            $query = "INSERT INTO users (email, password,pseudo) VALUES (:email, :password,:pseudo)";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([
                ':email' => $email,
                ':password' => $password,
                ':pseudo' => $pseudo
            ]);
        } catch (PDOException $e) {
            error_log("Error creating user: " . $e->getMessage());
            return false;
        }
    }

    public function verify($email, $password) {
        try {
            $query = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error verifying user: " . $e->getMessage());
            return false;
        }
    }

    public function emailExists($email) {
        try {
            $query = "SELECT COUNT(*) FROM users WHERE email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([':email' => $email]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Error checking email existence: " . $e->getMessage());
            return false;
        }
    }
    public function getLeaderboard($limit = 10) {
        $query = "SELECT u.email, s.score, s.total_questions, s.played_at 
                  FROM users u
                  JOIN scores s ON u.id = s.user_id
                  ORDER BY s.score DESC, s.played_at ASC
                  LIMIT :limit";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function isAdmin($userId) {
        try {
            $query = "SELECT is_admin FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([':id' => $userId]);
            return (bool) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error checking admin status: " . $e->getMessage());
            return false;
        }
    }
    
    public function getAll()
    {
        $sql = "SELECT id, email, is_admin, created_at FROM users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
    public function update($id, $email, $is_admin, $password = null, $updatePassword = false)
{
    if ($updatePassword) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $sql = "UPDATE users SET email = :email, is_admin = :is_admin, password = :password WHERE id = :id";
    } else {
        $sql = "UPDATE users SET email = :email, is_admin = :is_admin WHERE id = :id";
    }

    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':is_admin', $is_admin);
    $stmt->bindParam(':id', $id);

    if ($updatePassword) {
        $stmt->bindParam(':password', $passwordHash);
    }

    return $stmt->execute();
}
public function getById($id)
{
    $sql = "SELECT id, email, is_admin FROM users WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    
}
