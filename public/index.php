<?php
// Active l'affichage des erreurs pour le débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Démarre la session pour gérer les variables de session
session_start();

// Routeur
$page = $_GET['page'] ?? 'home'; // Récupère la page demandée via le paramètre GET ou utilise 'home' par défaut

// Charge le contrôleur approprié en fonction de la page
switch ($page) {
    // Authentification : Connexion
    case 'login':
        require_once dirname(__DIR__) . '/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login(); // Appelle la méthode de connexion
        break;

    // Authentification : Inscription
    case 'register':
        require_once dirname(__DIR__) . '/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register(); // Appelle la méthode d'inscription
        break;

    // Authentification : Déconnexion
    case 'logout':
        require_once dirname(__DIR__) . '/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout(); // Appelle la méthode de déconnexion
        break;

    // Catégories de quiz
    case 'categories':
        require_once dirname(__DIR__) . '/controllers/GameController.php';
        $controller = new GameController();
        $controller->categories(); // Affiche les catégories
        break;

    // Lancement d'un quiz
    case 'quiz':
        require_once dirname(__DIR__) . '/controllers/GameController.php';
        $controller = new GameController();
        $controller->quiz(); // Lance le quiz
        break;

    // Recherche dans les quiz
    case 'search':
        require_once dirname(__DIR__) . '/controllers/SearchController.php';
        require_once dirname(__DIR__) . '/models/QuizModel.php';
        require_once dirname(__DIR__) . '/config/Database.php';

        // Initialise la connexion à la base de données
        $database = new Database();
        $db = $database->getConnection();

        $searchController = new SearchController($db);
        $searchController->search(); // Effectue la recherche
        exit;

    // Classement des joueurs
    case 'ranking':
        require_once dirname(__DIR__) . '/controllers/RankingController.php';
        require_once dirname(__DIR__) . '/config/Database.php';

        try {
            $database = new Database();
            $pdo = $database->getConnection();

            $controller = new RankingController($pdo);
            $controller->showRanking(); // Affiche le classement
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage(); // Gestion des erreurs
        }
        break;

    // Page d'accueil
    case 'home':
        require_once dirname(__DIR__) . '/controllers/HomeController.php';
        require_once dirname(__DIR__) . '/config/Database.php';
        require_once dirname(__DIR__) . '/models/User.php';

        try {
            $database = new Database();
            $pdo = $database->getConnection();
            $userModel = new User();

            $controller = new HomeController($pdo);
            $controller->index(); // Affiche la page d'accueil
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage(); // Gestion des erreurs
        }
        break;

    // Page de contact
    case 'contact':
        require_once dirname(__DIR__) . '/controllers/TemplateController.php';
        $controller = new TemplateController();
        $controller->contact(); // Affiche la page de contact
        break;

    // Conditions Générales d'Utilisation (CGU)
    case 'gcu':
        require_once dirname(__DIR__) . '/controllers/TemplateController.php';
        $controller = new TemplateController();
        $controller->cgu(); // Affiche les CGU
        break;

    // Mentions légales
    case 'legal-notices':
        require_once dirname(__DIR__) . '/controllers/TemplateController.php';
        $controller = new TemplateController();
        $controller->legalNotices(); // Affiche les mentions légales
        break;

    // Footer
    case 'footer':
        require_once dirname(__DIR__) . '/controllers/TemplateController.php';
        $controller = new TemplateController();
        $footerLinks = $controller->footer(); // Gère les liens du footer
        break;

    // Sauvegarde des scores
    case 'saveScore':
        require_once dirname(__DIR__) . '/controllers/RankingController.php';
        require_once dirname(__DIR__) . '/config/Database.php';

        try {
            $database = new Database();
            $pdo = $database->getConnection();

            $controller = new RankingController($pdo);
            $controller->saveScore(); // Sauvegarde le score
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage(); // Gestion des erreurs
        }
        break;

    // Administration
    case 'admin':
        require_once dirname(__DIR__) . '/controllers/admin/AdminController.php';
        $controller = new AdminController();
        $action = $_GET['action'] ?? 'dashboard'; // Récupère l'action ou utilise 'dashboard' par défaut

        // Sous-actions pour l'administration
        switch ($action) {
            case 'add_question':
                $controller->addQuestion(); // Ajoute une question
                break;
            case 'edit_question':
                $controller->editQuestion(); // Modifie une question
                break;
            case 'delete_question':
                $controller->deleteQuestion(); // Supprime une question
                break;
            case 'categories':
                $controller->manageCategories(); // Gère les catégories
                break;
            case 'users':
                if (isset($_GET['manage']) && $_GET['manage'] === 'delete_user' && isset($_GET['id'])) {
                    $controller->deleteUser($_GET['id']); // Supprime un utilisateur
                } elseif (isset($_GET['manage']) && $_GET['manage'] === 'edit_user' && isset($_GET['id'])) {
                    $controller->editUser($_GET['id']); // Modifie un utilisateur
                } else {
                    $controller->manageUsers(); // Gère les utilisateurs
                }
                break;

            default:
                $controller->dashboard(); // Affiche le tableau de bord par défaut
                break;
        }
        break;

    // Nouveau case pour un point d'API (ajout futur)
}
