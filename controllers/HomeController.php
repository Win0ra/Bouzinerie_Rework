<?php
require_once dirname(__DIR__) . '/models/User.php';           // Modèle pour les utilisateurs
require_once dirname(__DIR__) . '/models/RankingModel.php';   // Modèle pour les classements
require_once dirname(__DIR__).'/models/Question.php';         // Modèle pour les questions
require_once dirname(__DIR__).'/models/Category.php';         // Modèle pour les catégories

class HomeController {
    // Propriétés pour les modèles utilisés dans ce contrôleur
    private $userModel;
    private $rankingModel;
    private $questionModel;
    private $categoryModel;

    // Constructeur : initialise les modèles avec une connexion PDO pour RankingModel
    public function __construct($pdo) {
        $this->userModel = new User();                          // Initialisation du modèle User
        $this->rankingModel = new RankingModel($pdo);           // Initialisation du modèle RankingModel avec PDO
        $this->questionModel = new Question();                  // Initialisation du modèle Question
        $this->categoryModel = new Category();                  // Initialisation du modèle Category
    }

    // Méthode principale pour afficher la page d'accueil
    public function index() {
        // Récupère le classement via le modèle RankingModel
        $ranking = $this->rankingModel->getRanking();

        // Debug : Enregistre les données du classement dans le journal pour vérifier leur contenu
        error_log('Données du ranking avant inclusion de la vue : ' . print_r($ranking, true));

        // Extraire les données pour les rendre disponibles dans la vue
        extract(['ranking' => $ranking]);

        // Récupère les catégories pour les afficher sur la page d'accueil
        $categories = $this->categoryModel->getAll();
        $userModel = $this->userModel;

        // Inclut la vue d'accueil
        require dirname(__DIR__) . '/views/home/index.php';
    }

    // Méthode pour afficher la liste des catégories
    public function categories() {
        // Vérifie si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
            header('Location: index.php?page=login');
            exit;
        }

        // Récupère toutes les catégories via le modèle Category
        $categories = $this->categoryModel->getAll();

        // Charge la vue qui affiche les catégories
        require dirname(__DIR__) . '/views/home/content.php';
    }

    // Méthode pour afficher les questions d'un quiz basé sur une catégorie
    public function quiz() {
        // Vérifie si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
            header('Location: index.php?page=login');
            exit;
        }

        // Récupère l'ID de la catégorie depuis les paramètres GET
        $categoryId = isset($_GET['category']) ? $_GET['category'] : null;

        // Si aucun ID de catégorie n'est fourni, redirige vers la liste des catégories
        if (!$categoryId) {
            header('Location: index.php?page=categories');
            exit;
        }

        // Récupère les informations de la catégorie via le modèle Category
        $category = $this->categoryModel->getById($categoryId);

        // Récupère les questions associées à la catégorie via le modèle Question
        $questions = $this->questionModel->getByCategory($categoryId);

        // Charge la vue qui affiche le quiz
        require dirname(__DIR__) . '/views/game/quiz.php';
    }
}
