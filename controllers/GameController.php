<?php
require_once dirname(__DIR__).'/models/Question.php';
require_once dirname(__DIR__).'/models/Category.php';

class GameController {
    private $questionModel;
    private $categoryModel;

    public function __construct() {
        $this->questionModel = new Question();
        $this->categoryModel = new Category();
    }

    public function categories() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

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

        $category = $this->categoryModel->getById($categoryId);
        $questions = $this->questionModel->getByCategory($categoryId);
        require dirname(__DIR__). '/views/game/quiz.php';
    }
}

