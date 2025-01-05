<?php
require_once dirname(__DIR__).'/models/Question.php'; // Inclusion du modèle Question
require_once dirname(__DIR__).'/models/Category.php'; // Inclusion du modèle Category
require_once dirname(__DIR__).'/models/User.php';     // Inclusion du modèle User
require_once dirname(__DIR__).'/models/Score.php';    // Inclusion du modèle Score

class GameController {
    // Propriétés pour les modèles utilisés dans le contrôleur
    private $questionModel;
    private $categoryModel;
    private $userModel;
    private $scoreModel; // Propriété pour le modèle Score

    // Constructeur : initialise les modèles
    public function __construct() {
        $this->questionModel = new Question();    // Initialisation du modèle Question
        $this->categoryModel = new Category();    // Initialisation du modèle Category
        $this->userModel = new User();            // Initialisation du modèle User
        $this->scoreModel = new Score();          // Initialisation du modèle Score
    }

    // Méthode pour afficher les catégories disponibles
    public function categories() {
        // Vérifie si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login'); // Redirection vers la page de connexion
            exit;
        }

        // Récupère toutes les catégories via le modèle Category
        $categories = $this->categoryModel->getAll();

        // Charge la vue des catégories
        require dirname(__DIR__).'/views/game/categories.php';
    }

    // Méthode pour afficher le quiz d'une catégorie donnée
    public function quiz() {
        // Vérifie si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login'); // Redirection vers la page de connexion
            exit;
        }

        // Récupère l'ID de la catégorie depuis les paramètres GET
        $categoryId = isset($_GET['category']) ? $_GET['category'] : null;
        if (!$categoryId) {
            // Redirige vers la page des catégories si aucun ID n'est fourni
            header('Location: index.php?page=categories');
            exit;
        }

        // Récupère les informations de la catégorie et les questions associées
        $category = $this->categoryModel->getById($categoryId);
        $questions = $this->questionModel->getByCategory($categoryId);

        // Charge la vue du quiz
        require dirname(__DIR__).'/views/game/quiz.php';
    }

    // Méthode pour enregistrer le score d'un utilisateur
    public function saveScore($userId, $score, $totalQuestions, $quizId): bool {
        // Validation des paramètres
        if (!is_int($userId) || !is_int($score) || !is_int($totalQuestions) || !is_int($quizId)) {
            throw new InvalidArgumentException("Invalid parameters"); // Lance une exception si les paramètres sont invalides
        }
    
        // Appelle la méthode saveScore du modèle Score pour enregistrer le score
        return $this->scoreModel->saveScore($userId, $score, $totalQuestions, $quizId);
    }
}
