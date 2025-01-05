<?php
require_once dirname(__DIR__) . '/models/QuizModel.php'; // Inclusion du modèle pour gérer les quiz

class SearchController {
    // Propriétés pour la connexion à la base de données et le modèle Quiz
    private $quizModel;
    private $db;

    // Constructeur : initialise la connexion à la base de données et le modèle Quiz
    public function __construct($db) {
        $this->db = $db; // Connexion à la base de données
        $this->quizModel = new QuizModel($this->db); // Initialisation du modèle QuizModel
    }
    
    // Méthode pour effectuer une recherche de quiz
    public function search() {
    // Vérifie si un paramètre 'q' (recherche) est fourni dans l'URL
        if (!isset($_GET['q'])) {
    // Si le paramètre est manquant, retourne une réponse JSON avec une erreur 400 (Requête invalide)
            $this->jsonResponse(['error' => 'Requête invalide'], 400);
            return;
        }

        try {
    // Récupère la requête de recherche et la sécurise avec htmlspecialchars
            $query = htmlspecialchars($_GET['q']); // Sécurisation de l'entrée
    // Effectue une recherche dans les quiz à l'aide du modèle QuizModel
            $results = $this->quizModel->searchQuizzes($query);
    // Retourne les résultats de la recherche en format JSON
            $this->jsonResponse($results);
        } catch (Exception $e) {
            // Log l'erreur pour le debugging
            error_log($e->getMessage());
    // Retourne une réponse JSON avec une erreur 500 (Erreur serveur)
            $this->jsonResponse(['error' => 'Erreur serveur'], 500);
        }
    }
    
    // Méthode pour envoyer une réponse JSON
    private function jsonResponse($data, $status = 200) {
        header('Content-Type: application/json'); // Définit le type de contenu comme JSON
        http_response_code($status); // Définit le code de réponse HTTP
        echo json_encode($data); // Encode les données en JSON et les renvoie
        exit; // Stoppe l'exécution pour éviter tout contenu supplémentaire
    }
}