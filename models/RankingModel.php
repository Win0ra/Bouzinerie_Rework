<?php
require_once dirname(__DIR__) . '/config/Database.php'; // Inclusion de la configuration de la base de données

class RankingModel
{
    // Propriété pour stocker la connexion à la base de données
    private $conn;

    // Constructeur : initialise la connexion à la base de données
    public function __construct($conn)
    {
        $this->conn = $conn; // Stocke la connexion PDO
    }

    // Méthode pour récupérer le classement des utilisateurs
    public function getRanking()
    {
        // Requête SQL pour calculer le classement
        $sql = "SELECT 
                u.id,                                -- ID de l'utilisateur
                u.pseudo,                            -- Pseudo de l'utilisateur
                SUM(s.score) as total_score,         -- Somme totale des scores de l'utilisateur
                COUNT(s.id) as games_played          -- Nombre de parties jouées par l'utilisateur
            FROM users u
            LEFT JOIN scores s ON u.id = s.user_id   -- Jointure pour associer les scores aux utilisateurs
            GROUP BY u.id, u.pseudo                 -- Groupe par utilisateur pour calculer les totaux
            ORDER BY total_score DESC               -- Trie les utilisateurs par score total décroissant
            LIMIT 10                                -- Limite les résultats aux 10 premiers
        ";
        
        try {
            // Préparation de la requête SQL
            $stmt = $this->conn->prepare($sql);
            
            // Exécution de la requête
            $stmt->execute();
            
            // Récupération des résultats sous forme de tableau associatif
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Debug : Enregistre les résultats du classement dans les logs pour le débogage
            error_log("Résultats du classement : " . print_r($results, true));
            
            // Retourne les résultats du classement
            return $results;
        } catch (PDOException $e) {
            // Enregistre l'erreur dans les logs en cas de problème SQL
            error_log("Erreur SQL dans getRanking: " . $e->getMessage());
            
            // Retourne un tableau vide en cas d'erreur
            return [];
        }
    }
}
