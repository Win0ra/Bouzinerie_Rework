<?php
class Database {
    private $host = "127.0.0.1";
    private $db_name = "quiz_rework";
    private $username = "root";
    private $password = "19972727Ab&k";
    private $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Test the connection with a simple query
            $stmt = $this->conn->query("SELECT 1");
            $result = $stmt->fetch();
        } catch(PDOException $e) {
            echo "Erreur de connexion: " . $e->getMessage();
        }
        return $this->conn;
    }
}