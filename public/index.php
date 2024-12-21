<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();


// Router
$page = $_GET['page'] ?? 'home';

// Load appropriate controller
switch($page) {
    case 'login':
        require_once dirname(__DIR__). '/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;
        
    case 'register':
        require_once dirname(__DIR__). '/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();
        break;
        
    case 'logout':
        require_once dirname(__DIR__). '/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;
        
    case 'categories':
        require_once dirname(__DIR__). '/controllers/GameController.php';
        $controller = new GameController();
        $controller->categories();
        break;
        
    case 'quiz':
        require_once dirname(__DIR__). '/controllers/GameController.php';
        $controller = new GameController();
        $controller->quiz();
        break;
        
    case 'home':
    default:
        require_once dirname(__DIR__). '/controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
    case 'admin':
        require_once dirname(__DIR__). '/controllers/admin/AdminController.php';
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
                require_once dirname(__DIR__) . '/controllers/admin/AdminController.php';
                $controller = new AdminController();
                if (isset($_GET['manage']) && $_GET['manage'] === 'delete_user' && isset($_GET['id'])) {
                    
                        $controller->deleteUser($_GET['id']);
                }                
                if (isset($_GET['manage']) && $_GET['manage'] === 'edit_user' && isset($_GET['id'])) {

                    $controller->editUser($_GET['id']);
                }
                else {
                    $controller->manageUsers();
                }
                break;
                
            default:
                $controller->dashboard();
                break;
        }
        break;
    
}
