<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Include Composer autoload

require_once dirname(__DIR__). '/models/User.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController {
    private $userModel;

    public function __construct() {
        // Initialisation du modèle User
        $this->userModel = new User();
    }
    public function sendResetLink() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            // Here you would typically check if the email exists in the database
            // Encrypt the email to create a token
            $token = base64_encode($email); // Encrypt the email
            // Save token to the database associated with the email

            // Send email
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp-relay.brevo.com';
                $mail->SMTPAuth = true;
                $mail->Username = '81a202001@smtp-brevo.com';
                $mail->Password = 'bZwK7QSAcDJ5WCvj';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('a.eightid@gmail.com', 'eight');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
                $host = $_SERVER['HTTP_HOST'];
                $baseUrl = $protocol . "://" . $host;
                
                // Set the email body with the dynamic base URL
                $mail->Body = 'Click <a href="' . $baseUrl . '/index.php?page=reset-password&token=' . urlencode($token) . '">here</a> to reset your password.';
                
                $mail->send();
                echo 'Reset link has been sent to your email.';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
    public function updatePassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['token'];
            $newPassword = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
            // Validate the token and retrieve the associated email
            $email = base64_decode($token); 
            if ($email && $newPassword === $confirmPassword) {
                if($this->userModel->updatePassword($email,$newPassword)) {
                    header('Location: index.php?page=login&reset=1');
                }
            } else {

                echo 'Passwords do not match.';
            }
        }
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
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['email'] = $user['email'];
                        $_SESSION['pseudo'] = $user['pseudo'];
                        $_SESSION['success'] = "Connexion réussie!";

                        if (isset($_POST['checkbox'])) {
                            // Définit un cookie pour se souvenir de l'utilisateur pendant 30 jours
                            setcookie('remember_me', $user['email'], time() + (30 * 24 * 60 * 60), "/"); // 30 jours
                            // Définit un cookie pour le mot de passe pendant 30 jours
                            setcookie('remember_password', $password, time() + (30 * 24 * 60 * 60), "/"); // 30 jours
                        } else {
                            // Si non coché, supprime le cookie de mot de passe
                            setcookie('remember_password', '', time() - 3600, "/"); // Supprime le cookie
                            setcookie('remember_me', '', time() - 3600, "/"); // Supprime le cookie
}
                        
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

    public function loginGoogle()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $token = $data['token'];

        $client = new Google_Client(['client_id' => '1034339065791-3thgahi0eg6f1bbvgets1ljnvvldmkn4.apps.googleusercontent.com']); // Specify your client ID
        $payload = $client->verifyIdToken($token);
        if ($payload) {
            $email = $payload['email'];
            $name = $payload['name'];

            $user = $this->userModel->findByEmail($email);
            if (!$user) {
                $this->userModel->create($email, '', $name); 
            }
            $user = $this->userModel->findByEmail($email);

            // Log the user in
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $email;
            $_SESSION['pseudo'] = trim($name); 

            // Redirect to the home page
            header('Location: index.php?page=home');
            
            exit;
        } else {
            // Invalid token
            echo 'Invalid ID token';
        }
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
                $errors[] = "Le mot de passe doit contenir au moins 6 caractères*";
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
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

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
    public  function showResetPage()
    {
        require dirname(__DIR__).'/views/auth/reset_password_request.php';
    }
    public function showChangePasswordPage()
    {
        require dirname(__DIR__).'/views/auth/reset_password.php';

    }
}
