<?php
require_once dirname(__DIR__) . '/config/Database.php'; // Inclusion de la configuration de la base de données

class QuizModel {
    // Propriétés pour la connexion à la base de données et le nom de la table
    private $db;
    private $table = 'categories'; // Nom de la table utilisée pour les quiz (ici : "categories")
    
    // Constructeur : initialise la connexion à la base de données
    public function __construct($db) {
        $this->db = $db; // Stocke la connexion PDO
    }
    
    // Méthode pour rechercher des quiz
    public function searchQuizzes($query) {
        try {
            // Requête SQL pour rechercher les quiz dans la table "categories" dont le nom correspond à la requête
            $sql = "SELECT id, name as title, image 
                    FROM " . $this->table . " 
                    WHERE name LIKE :query
                    ORDER BY name ASC"; // Tri alphabétique par nom
            
            // Préparation de la requête SQL
            $stmt = $this->db->prepare($sql);
            
            // Exécution de la requête avec la recherche (%query%) pour inclure des correspondances partielles
            $stmt->execute(['query' => "%" . trim($query) . "%"]);
            
            // Retourne les résultats sous forme de tableau associatif
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            // Log l'erreur pour faciliter le débogage
            error_log("Erreur dans QuizModel::searchQuizzes : " . $e->getMessage());
            
            // Lance une exception générique pour ne pas exposer de détails sensibles à l'utilisateur
            throw new Exception("Erreur lors de la recherche des quiz");
        }
    }
    
    // Private function pour nettoyer les données d'entrée
    private function sanitizeInput($input) {
        // Supprime les espaces inutiles et encode les caractères spéciaux pour éviter les problèmes de sécurité
        return trim(htmlspecialchars($input));
    }
}
