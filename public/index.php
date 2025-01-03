<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Router
$page = $_GET['page'] ?? 'home';

// Load appropriate controller
switch ($page) {
    case 'login':
        require_once dirname(__DIR__) . '/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;

    case 'register':
        require_once dirname(__DIR__) . '/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();
        break;

    case 'logout':
        require_once dirname(__DIR__) . '/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;

    case 'categories':
        require_once dirname(__DIR__) . '/controllers/GameController.php';
        $controller = new GameController();
        $controller->categories();
        break;

    case 'quiz':
        require_once dirname(__DIR__) . '/controllers/GameController.php';
        $controller = new GameController();
        $controller->quiz();
        break;

    case 'ranking':
        require_once dirname(__DIR__) . '/controllers/RankingController.php';
        require_once dirname(__DIR__) . '/config/Database.php';

        try {
            $database = new Database();
            $pdo = $database->getConnection();

            $controller = new RankingController($pdo);
            $controller->showRanking();
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
        break;

    case 'home':
        require_once dirname(__DIR__) . '/controllers/HomeController.php';
        require_once dirname(__DIR__) . '/config/Database.php';
        require_once dirname(__DIR__) . '/models/User.php';

        try {
            $database = new Database();
            $pdo = $database->getConnection();
            $userModel = new User();

            $controller = new HomeController($pdo);
            $controller->index();
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
        break;

    case 'contact':
        require_once dirname(__DIR__) . '/controllers/TemplateController.php';
        $controller = new TemplateController();
        $controller->contact();
        break;
    
    case 'gcu':
        require_once dirname(__DIR__) . '/controllers/TemplateController.php';
        $controller = new TemplateController();
        $controller->cgu();
        break;
    
    case 'legal-notices':
        require_once dirname(__DIR__) . '/controllers/TemplateController.php';
        $controller = new TemplateController();
        $controller->legalNotices();
        break;
    
    case 'footer':
        require_once dirname(__DIR__) . '/controllers/TemplateController.php';
        $controller = new TemplateController();
        $footerLinks = $controller->footer();
        break;
    case 'saveScore':
        require_once dirname(__DIR__) . '/controllers/RankingController.php';
        require_once dirname(__DIR__) . '/config/Database.php';

        try {
            $database = new Database();
            $pdo = $database->getConnection();

            $controller = new RankingController($pdo);
            $controller->saveScore(); // Call the saveScore method
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
        break;
    
    case 'admin':
        require_once dirname(__DIR__) . '/controllers/admin/AdminController.php';
        $controller = new AdminController();
        $action = $_GET['action'] ?? 'dashboard';

        switch ($action) {
            case 'add_question':
                $controller->addQuestion();
                break;
            case 'edit_question':
                $controller->editQuestion();
                break;
            case 'delete_question':
                $controller->deleteQuestion();
                break;
            case 'categories':
                $controller->manageCategories();
                break;
            case 'users':
                if (isset($_GET['manage']) && $_GET['manage'] === 'delete_user' && isset($_GET['id'])) {
                    $controller->deleteUser($_GET['id']);
                } elseif (isset($_GET['manage']) && $_GET['manage'] === 'edit_user' && isset($_GET['id'])) {
                    $controller->editUser($_GET['id']);
                } else {
                    $controller->manageUsers();
                }
                break;

            default:
                $controller->dashboard();
                break;
        }
        break;

    // New case for API endpoint
}
