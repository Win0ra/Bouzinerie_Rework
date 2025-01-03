<?php
require_once __DIR__ . '/../../models/Question.php';
require_once __DIR__ . '/../../models/Category.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/Score.php';

class AdminController {
    private $questionModel;
    private $categoryModel;
    private $userModel;

    public function __construct() {
        $this->userModel = new User();

        if (!$this->checkAdminAccess()) {
            header('Location: index.php?page=home');
            exit;
        }
        
        $this->questionModel = new Question();
        
        $this->categoryModel = new Category();
        $this->userModel = new User();
    }

    private function checkAdminAccess() {
        if (!isset($_SESSION['user_id'])) {
            return false;
        }
        
        $userModel = new User();
        return $userModel->isAdmin($_SESSION['user_id']);
    }

    public function dashboard() {
        $questions = $this->questionModel->getAll();
        $categories = $this->categoryModel->getAll();
        require  __DIR__ . '/../../views/admin/dashboard.php';

    }

    public function addQuestion() {
        $categories = $this->categoryModel->getAll();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $question = $this->questionModel->getById($id);
        }
        $errors = [];
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $question = $_POST['question'] ?? '';
            $answers = $_POST['answers'] ?? [];
            $correctAnswer = $_POST['correct_answer'] ?? '';
            $categoryId = $_POST['category_id'] ?? '';

            // Validation
            if (empty($question)) $errors[] = "La question est requise";
            if (count($answers) < 4) $errors[] = "4 réponses sont requises";
            if (!isset($correctAnswer)) $errors[] = "La bonne réponse est requise";
            if (empty($categoryId)) $errors[] = "La catégorie est requise";

            if (empty($errors)) {
                if ($this->questionModel->create($question, json_encode($answers), $correctAnswer, $categoryId)) {
                    $success = "Question ajoutée avec succès";
                    header("Refresh: 1; url=index.php?page=admin&action=questions");

                } else {
                    $errors[] = "Erreur lors de l'ajout de la question";
                }
            }
        }

        require __DIR__ . '/../../views/admin/question_form.php';

    }

    public function editQuestion() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?page=admin');
            exit;
        }

        $categories = $this->categoryModel->getAll();
        $question = $this->questionModel->getById($id);
        $errors = [];
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $questionText = $_POST['question'] ?? '';
            $answers = $_POST['answers'] ?? [];
            $correctAnswer = $_POST['correct_answer'] ?? '';
            $categoryId = $_POST['category_id'] ?? '';

            if (empty($questionText)) $errors[] = "La question est requise";
            if (count($answers) < 4) $errors[] = "4 réponses sont requises";
            if (!isset($correctAnswer)) $errors[] = "La bonne réponse est requise";
            if (empty($categoryId)) $errors[] = "La catégorie est requise";

            if (empty($errors)) {
                if ($this->questionModel->update($id, $questionText, json_encode($answers), $correctAnswer, $categoryId)) {
                    $success = "Question mise à jour avec succès";
                    $question = $this->questionModel->getById($id);
                } else {
                    $errors[] = "Erreur lors de la mise à jour de la question";
                }
            }
        }

        require __DIR__ . '/../../views/admin/question_form.php';

    }

    public function deleteQuestion() {
        $id = $_GET['id'] ?? null;
        if ($id && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->questionModel->delete($id);
        }
        header('Location: index.php?page=admin');
        exit;
    }

    public function manageCategories() {
        $categories = $this->categoryModel->getAll();
        $errors = [];
        $success = '';
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $categoryId = $_POST['category_id'] ?? null;
            $image = $_FILES['image'] ?? null;
    
            if ($action === 'add') {
                if (empty($name)) {
                    $errors[] = "Le nom de la catégorie est requis";
                } else {
                    $imagePath = null;
    
                    // Handle image upload if provided
                    if ($image && $image['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = dirname(__DIR__) . '/uploads/categories/';
                        if (!is_dir($uploadDir)) {
                            if (!mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
                                $errors[] = "Impossible de créer le répertoire des téléchargements.";
                            }
                        }
                        chmod($uploadDir, 0755);

                        $imagePath = $uploadDir . basename($image['name']);
                        if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
                            $errors[] = "Erreur lors du déplacement du fichier téléchargé.";
                        }
                    }
    
                    if (empty($errors) && $this->categoryModel->create($name, $description, $imagePath)) {
                        $success = "Catégorie ajoutée avec succès";
                        $categories = $this->categoryModel->getAll();
                    }
                }
            } else if ($action === 'edit') {
                if (empty($name) || empty($categoryId)) {
                    $errors[] = "Le nom et l'ID de la catégorie sont requis";
                } else {
                    $imagePath = null;
    
                    // Check if a new image is uploaded
                    if ($image && $image['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = dirname(__DIR__) . '/uploads/categories/';
                        if (!is_dir($uploadDir)) {
                            if (!mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
                                $errors[] = "Impossible de créer le répertoire des téléchargements.";
                            }
                        }
    
                        $imagePath = $uploadDir . basename($image['name']);
                        if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
                            $errors[] = "Erreur lors du déplacement du fichier téléchargé.";
                        }
                    } else {
                        // Retain the current image if no new image is uploaded
                        $existingCategory = $this->categoryModel->getById($categoryId);
                        if ($existingCategory && isset($existingCategory['image'])) {
                            $imagePath = $existingCategory['image'];
                        }
                    }
    
                    if (empty($errors) && $this->categoryModel->update($categoryId, $name, $description, $imagePath)) {
                        $success = "Catégorie mise à jour avec succès";
                        $categories = $this->categoryModel->getAll();
                    } else {
                        $errors[] = "Une erreur s'est produite lors de la mise à jour de la catégorie";
                    }
                }
            } else if ($action === 'delete') {
                if (empty($categoryId)) {
                    $errors[] = "L'ID de la catégorie est requis pour la suppression.";
                } else if ($this->categoryModel->delete($categoryId)) {
                    $success = "Catégorie supprimée avec succès";
                    $categories = $this->categoryModel->getAll();
                }
            }
        }
    
        require __DIR__ . '/../../views/admin/categories.php';
    }
    

    public function index() {
        // Fetch leaderboard data
        $leaderboard = $this->userModel->getLeaderboard();

        require __DIR__ . '/../../views/admin/dashboard.php';
    }

    public function manageUsers()
    {
        require_once dirname(__DIR__, 2) . '/models/User.php';
        $userModel = new User();

        require_once dirname(__DIR__, 2) . '/models/Score.php';
        $scoreModel = new Score();

        $users = $userModel->getAll();
        foreach ($users as &$user) {
            $user['scores'] = $scoreModel->getByUserId($user['id']);
        }

        require_once __DIR__ . '/../../views/admin/manage_users.php';
    }
    public function deleteUser($id)
    {
        require_once dirname(__DIR__, 2) . '/models/User.php';
        $userModel = new User();

        if ($userModel->delete($id)) {
            $_SESSION['success'] = "Utilisateur supprimé avec succès.";
        } else {
            $_SESSION['error'] = "Échec de la suppression de l'utilisateur.";
        }

        header('Location: index.php?page=admin&action=manage_users');
        exit;
    }

    public function editUser($id)
    {
        require_once __DIR__. '/../../models/User.php';
        $userModel = new User();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $is_admin = isset($_POST['is_admin']) ? 1 : 0;
            $password = $_POST['password'];
    
            $updatePassword = !empty($password);
            $updated = $userModel->update($id, $email, $is_admin, $password, $updatePassword);
    
            if ($updated) {
                $_SESSION['success'] = "Informations de l'utilisateur mises à jour avec succès.";
            } else {
                $_SESSION['error'] = "Échec de la mise à jour des informations de l'utilisateur.";
            }
            header('Location: index.php?page=admin_users');
            exit;
        }
    
        $user = $userModel->getById($id);
        require_once __DIR__ . '/../../views/admin/edit_user.php';
    }
    
}