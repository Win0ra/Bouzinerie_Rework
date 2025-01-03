<?php
require_once dirname(__DIR__). '/models/User.php';

class AuthController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        $errors = [];
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            // Validation
            if (empty($email)) {
                $errors[] = "L'email est requis";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Format d'email invalide";
            }

            if (empty($password)) {
                $errors[] = "Le mot de passe est requis";
            }

            // If no validation errors, attempt login
            if (empty($errors)) {
                try {
                    if ($user = $this->userModel->verify($email, $password)) {
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['email'] = $user['email'];
                        $_SESSION['success'] = "Connexion réussie!";
                        header('Location: index.php?page=home');
                        exit;
                    } else {
                        $errors[] = "Email ou mot de passe incorrect";
                    }
                } catch (Exception $e) {
                    $errors[] = "Une erreur est survenue lors de la connexion";
                }
            }
        }
        
        require dirname(__DIR__).'/views/auth/login.php';
    }

    public function register() {
        $errors = [];
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';
            $pseudo = $_POST['pseudo'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Validation
            if (empty($email)) {
                $errors[] = "L'email est requis";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Format d'email invalide";
            }
            if (empty($pseudo)) {
                $errors[] = "le pseudo est requis";
            } 
            if (empty($password)) {
                $errors[] = "Le mot de passe est requis";
            } elseif (strlen($password) < 6) {
                $errors[] = "Le mot de passe doit contenir au moins 6 caractères";
            }

            if ($password !== $confirmPassword) {
                $errors[] = "Les mots de passe ne correspondent pas";
            }

            // Check if email already exists
            if (empty($errors) && $this->userModel->emailExists($email)) {
                $errors[] = "Cet email est déjà utilisé";
            }

            // If no validation errors, attempt registration
            if (empty($errors)) {
                try {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    if ($this->userModel->create($email, $hashedPassword,$pseudo)) {
                        $success = "Inscription réussie! Vous pouvez maintenant vous connecter.";
                        header('Location: index.php?page=login');

                    } else {
                        $errors[] = "Une erreur est survenue lors de l'inscription";
                    }
                } catch (Exception $e) {
                    $errors[] = "Une erreur est survenue lors de l'inscription";
                }
            }
        }
        
        require dirname(__DIR__).'/views/auth/register.php';
    }

    public function logout() {
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }
}
