<?php
require_once dirname(__DIR__). '/models/User.php';

class AuthController {
    // Modèle User utilisé pour les opérations liées aux utilisateurs
    private $userModel;

    public function __construct() {
        // Initialisation du modèle User
        $this->userModel = new User();
    }

    // Gère le processus de connexion des utilisateurs
    public function login() {
        $errors = []; // Tableau pour stocker les erreurs de validation
        $success = ''; // Message de succès (s'il y en a)

        // Vérifie si la méthode HTTP est POST (soumission du formulaire)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupère et filtre l'email de l'utilisateur
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? ''; // Récupère le mot de passe saisi

            // Validation des champs du formulaire
            if (empty($email)) {
                $errors[] = "L'email est requis";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Format d'email invalide";
            }

            if (empty($password)) {
                $errors[] = "Le mot de passe est requis";
            }

            // Si aucune erreur de validation, on tente la connexion
            if (empty($errors)) {
                try {
                    // Vérifie les identifiants via le modèle User
                    if ($user = $this->userModel->verify($email, $password)) {
                        // Stocke les informations de l'utilisateur en session
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['email'] = $user['email'];
                        $_SESSION['success'] = "Connexion réussie!";
                        
                        // Redirige vers la page d'accueil
                        header('Location: index.php?page=home');
                        exit;
                    } else {
                        $errors[] = "Email ou mot de passe incorrect";
                    }
                } catch (Exception $e) {
                    // En cas d'erreur inattendue
                    $errors[] = "Une erreur est survenue lors de la connexion";
                }
            }
        }

        // Charge la vue de connexion avec les erreurs éventuelles
        require dirname(__DIR__).'/views/auth/login.php';
    }

    // Gère le processus d'inscription des utilisateurs
    public function register() {
        $errors = []; // Tableau pour stocker les erreurs de validation
        $success = ''; // Message de succès (s'il y en a)

        // Vérifie si la méthode HTTP est POST (soumission du formulaire)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupère et filtre les données du formulaire
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';
            $pseudo = $_POST['pseudo'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Validation des champs
            if (empty($email)) {
                $errors[] = "L'email est requis";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Format d'email invalide";
            }
            if (empty($pseudo)) {
                $errors[] = "Le pseudo est requis";
            } 
            if (empty($password)) {
                $errors[] = "Le mot de passe est requis";
            } elseif (strlen($password) < 6) {
                $errors[] = "Le mot de passe doit contenir au moins 6 caractères";
            }

            if ($password !== $confirmPassword) {
                $errors[] = "Les mots de passe ne correspondent pas";
            }

            // Vérifie si l'email existe déjà dans la base
            if (empty($errors) && $this->userModel->emailExists($email)) {
                $errors[] = "Cet email est déjà utilisé";
            }

            // Si aucune erreur de validation, on tente l'inscription
            if (empty($errors)) {
                try {
                    // Hachage sécurisé du mot de passe
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    // Création de l'utilisateur via le modèle User
                    if ($this->userModel->create($email, $hashedPassword, $pseudo)) {
                        $success = "Inscription réussie! Vous pouvez maintenant vous connecter.";
                        
                        // Redirige vers la page de connexion
                        header('Location: index.php?page=login');
                        exit;
                    } else {
                        $errors[] = "Une erreur est survenue lors de l'inscription";
                    }
                } catch (Exception $e) {
                    // En cas d'erreur inattendue
                    $errors[] = "Une erreur est survenue lors de l'inscription";
                }
            }
        }

        // Charge la vue d'inscription 
        require dirname(__DIR__).'/views/auth/register.php';
    }

    // Gère la déconnexion des utilisateurs
    public function logout() {
        // Détruit la session pour déconnecter l'utilisateur
        session_destroy();

        // Redirige vers la page de connexion
        header('Location: index.php?page=login');
        exit;
    }
}
