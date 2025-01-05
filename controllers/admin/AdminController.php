<?php
require_once __DIR__ . '/../../models/Question.php';
require_once __DIR__ . '/../../models/Category.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/Score.php';

class AdminController
{
    private $questionModel;
    private $categoryModel;
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    // Vérifie si l'utilisateur connecté a un accès administrateur
        if (!$this->checkAdminAccess()) {
            header('Location: index.php?page=home');
            exit;
        }
    // Initialisation des modèles
        $this->questionModel = new Question();

        $this->categoryModel = new Category();
        $this->userModel = new User();
    }
    // Vérifie si l'utilisateur connecté est un administrateur
    private function checkAdminAccess()
    {
        if (!isset($_SESSION['user_id'])) {
            return false;
        }

        $userModel = new User();
        return $userModel->isAdmin($_SESSION['user_id']);
    }

    // Affiche le tableau de bord de l'administrateur
    public function dashboard()
    {
        $questions = $this->questionModel->getAll();
        $categories = $this->categoryModel->getAll();
        require  __DIR__ . '/../../views/admin/dashboard.php';
    }
    // Affiche le formulaire d'ajout de question
    public function addQuestion()
    {
    // Récupère toutes les catégories
        $categories = $this->categoryModel->getAll();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $question = $this->questionModel->getById($id);
        }
        $errors = [];
        $success = '';
    // Si le formulaire est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $question = $_POST['question'] ?? '';
            $answers = $_POST['answers'] ?? [];
            $correctAnswer = $_POST['correct_answer'] ?? '';
            $categoryId = $_POST['category_id'] ?? '';

    // Validation des champs
            if (empty($question)) $errors[] = "La question est requise";
            if (count($answers) < 4) $errors[] = "4 réponses sont requises";
            if (!isset($correctAnswer)) $errors[] = "La bonne réponse est requise";
            if (empty($categoryId)) $errors[] = "La catégorie est requise";

            if (empty($errors)) {
    // Création de la question
                if ($this->questionModel->create($question, json_encode($answers), $correctAnswer, $categoryId)) {
                    $success = "Question ajoutée avec succès";
                    header("Refresh: 1; url=index.php?page=admin&action=questions");
                } else {
                    $errors[] = "Erreur lors de l'ajout de la question";
                }
            }
        }
    // Affiche le formulaire
        require __DIR__ . '/../../views/admin/question_form.php';
    }
    // Affiche le formulaire de modification de question
    public function editQuestion()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?page=admin');
            exit;
        }
    // Récupère toutes les catégories et la question
        $categories = $this->categoryModel->getAll();
        $question = $this->questionModel->getById($id);
        $errors = [];
        $success = '';
    // Si le formulaire est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $questionText = $_POST['question'] ?? '';
            $answers = $_POST['answers'] ?? [];
            $correctAnswer = $_POST['correct_answer'] ?? '';
            $categoryId = $_POST['category_id'] ?? '';
    // Validation des champs
            if (empty($questionText)) $errors[] = "La question est requise";
            if (count($answers) < 4) $errors[] = "4 réponses sont requises";
            if (!isset($correctAnswer)) $errors[] = "La bonne réponse est requise";
            if (empty($categoryId)) $errors[] = "La catégorie est requise";

            if (empty($errors)) {
    // Mise à jour de la question via le model
                if ($this->questionModel->update($id, $questionText, json_encode($answers), $correctAnswer, $categoryId)) {
                    $success = "Question mise à jour avec succès";
                    $question = $this->questionModel->getById($id);
                } else {
                    $errors[] = "Erreur lors de la mise à jour de la question";
                }
            }
        }
    // Affiche le formulaire
        require __DIR__ . '/../../views/admin/question_form.php';
    }
    // Supprime une question
    public function deleteQuestion()
    {
        $id = $_GET['id'] ?? null;
        if ($id && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->questionModel->delete($id);
        }
        header('Location: index.php?page=admin');
        exit;
    }
    // Gère les catégories (ajout, modification, suppression)
    public function manageCategories()
    {
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
    // Ajout d'une catégorie 
                if (empty($name)) {
                    $errors[] = "Le nom de la catégorie est requis";
                } else {
                    $imagePath = null;

    // Gestion de l'image
                    if ($image && $image['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = __DIR__ . '/../../views/uploads/categories/';

                        if (!is_dir($uploadDir)) {
                            if (!mkdir($uploadDir, 0777, true) && !is_dir($uploadDir)) {
                                $errors[] = "Impossible de créer le répertoire des téléchargements.";
                            }
                        }

                        $imagePath = $uploadDir . basename($image['name']);
                        if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
                            $errors[] = "Erreur lors du déplacement du fichier téléchargé.";
                        }
                    }

                    if (empty($errors) && $this->categoryModel->create($name, $description, basename($image['name']))) {
                        $success = "Catégorie ajoutée avec succès";
                        $categories = $this->categoryModel->getAll();
                    }
                }
            } else if ($action === 'edit') {
    // Mise à jour d'une catégorie
                if (empty($name) || empty($categoryId)) {
                    $errors[] = "Le nom et l'ID de la catégorie sont requis";
                } else {
                    $imagePath = null;

                    if ($image && $image['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = __DIR__ . '/../../views/uploads/categories/';
                        if (!is_dir($uploadDir)) {
                            if (!mkdir($uploadDir, 0777, true) && !is_dir($uploadDir)) {
                                $errors[] = "Impossible de créer le répertoire des téléchargements.";
                            }
                        }
                        $imagePath = $uploadDir . basename($image['name']);
                        if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
                            $errors[] = "Erreur lors du déplacement du fichier téléchargé.";
                        }
                    } else {
                        $existingCategory = $this->categoryModel->getById($categoryId);
                        if ($existingCategory && isset($existingCategory['image'])) {
                            $imagePath = $existingCategory['image'];
                        }
                    }

                    if (empty($errors) && $this->categoryModel->update($categoryId, $name, $description, basename($image['name']))) {
                        $success = "Catégorie mise à jour avec succès";
                        $categories = $this->categoryModel->getAll();
                    } else {
                        $errors[] = "Une erreur s'est produite lors de la mise à jour de la catégorie";
                    }
                }
            } else if ($action === 'delete') {
    // Suppression d'une catégorie
                if (empty($categoryId)) {
                    $errors[] = "L'ID de la catégorie est requis pour la suppression.";
                } else if ($this->categoryModel->delete($categoryId)) {
                    $success = "Catégorie supprimée avec succès";
                    $categories = $this->categoryModel->getAll();
                }
            }
        }
    // Affiche la vue de gestion des catégories
        require __DIR__ . '/../../views/admin/categories.php';
    }


    public function index()
    {
    // Récupère les questions et les catégories
        $leaderboard = $this->userModel->getLeaderboard();

        require __DIR__ . '/../../views/admin/dashboard.php';
    }
    // Affiche la gestion des utilisateurs
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
    // Supprime un utilisateur
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
    // Modifie un utilisateur
    public function editUser($id)
    {
        require_once __DIR__ . '/../../models/User.php';
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
    // Récupère l'utilisateur par son ID
        $user = $userModel->getById($id);
        require_once __DIR__ . '/../../views/admin/edit_user.php';
    }
}
