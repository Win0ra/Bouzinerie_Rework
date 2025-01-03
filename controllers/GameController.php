<?php
require_once dirname(__DIR__).'/models/Question.php';
require_once dirname(__DIR__).'/models/Category.php';
require_once dirname(__DIR__) . '/models/User.php';

class GameController {
    private $questionModel;
    private $categoryModel;
    private $userModel;

    public function __construct() {
        $this->questionModel = new Question();
        $this->categoryModel = new Category();
        $this->userModel = new User();

    }

    public function categories() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $userModel = $this->userModel;

        $categories = $this->categoryModel->getAll();
        require dirname(__DIR__). '/views/game/categories.php';
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
        $userModel = $this->userModel;

        $category = $this->categoryModel->getById($categoryId);
        $questions = $this->questionModel->getByCategory($categoryId);
        require dirname(__DIR__). '/views/game/quiz.php';
    }
}

