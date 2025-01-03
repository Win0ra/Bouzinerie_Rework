<?php
require_once dirname(__DIR__) . '/models/User.php';
require_once dirname(__DIR__) . '/models/RankingModel.php';
require_once dirname(__DIR__).'/models/Question.php';
require_once dirname(__DIR__).'/models/Category.php';

class HomeController {
    private $userModel;
    private $rankingModel;
    private $questionModel;
    private $categoryModel;

    public function __construct($pdo) {
        $this->userModel = new User();
        $this->rankingModel = new RankingModel($pdo);
        $this->questionModel = new Question();
        $this->categoryModel = new Category();
    }

    public function index() {
        $ranking = $this->rankingModel->getRanking();
    
        // Debug
        error_log('Données du ranking avant inclusion de la vue : ' . print_r($ranking, true));
    
        // Extraire les variables pour la vue
        extract(['ranking' => $ranking]);
    
        // Inclure la vue
        $userModel = $this->userModel;
        $categories = $this->categoryModel->getAll();
        require dirname(__DIR__) . '/views/home/index.php';
    }
    
    public function categories() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $categories = $this->categoryModel->getAll();
        require dirname(__DIR__). '/views/home/content.php';
    }

    public function quiz() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $categoryId = isset($_GET['category']) ? $_GET['category'] : null;
        if (!$categoryId) {
            header('Location: index.php?page=categories');
            exit;
        }

        $category = $this->categoryModel->getById($categoryId);
        $questions = $this->questionModel->getByCategory($categoryId);
        require dirname(__DIR__). '/views/game/quiz.php';
    }
}
