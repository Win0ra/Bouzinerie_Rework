<?php
require_once dirname(__DIR__).'/config/Database.php';

class RankingModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getRanking()
    {
        $sql = "SELECT 
                u.id,
                u.pseudo,
                SUM(s.score) as total_score,
                COUNT(s.id) as games_played
            FROM users u
            LEFT JOIN scores s ON u.id = s.user_id
            GROUP BY u.id, u.pseudo
            ORDER BY total_score DESC
            LIMIT 10
        ";
        
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            // Debug
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("Résultats du classement : " . print_r($results, true));
            
            return $results;
        } catch (PDOException $e) {
            error_log("Erreur SQL dans getRanking: " . $e->getMessage());
            return [];
        }
    }
}