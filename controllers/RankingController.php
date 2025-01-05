<?php
require_once dirname(__DIR__) . '/models/RankingModel.php'; // Modèle pour gérer les classements
require_once dirname(__DIR__) . '/models/User.php';          // Modèle pour gérer les utilisateurs
require_once dirname(__DIR__) . '/models/Score.php';         // Modèle pour gérer les scores

class RankingController
{
    // Propriétés pour les modèles utilisés dans le contrôleur
    private $rankingModel;
    private $userModel;
    // Constructeur : initialise les modèles
    public function __construct($pdo)
    {
        $this->rankingModel = new RankingModel($pdo); // Initialisation du modèle RankingModel avec PDO
        $this->userModel = new User(); // Initialisation du modèle User
    }
    
    // Méthode pour sauvegarder un score
    public function saveScore() {
    // Récupère les données JSON envoyées dans le corps de la requête
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['userId'], $data['score'], $data['quizId'], $data['totalCorrectQuestions'])) {
            $userId = $data['userId']; // ID de l'utilisateur
            $score = $data['score']; // Score obtenu
            $quizId = $data['quizId']; // ID du quiz
            $totalCorrectQuestions = $data['totalCorrectQuestions']; // Nombre de bonnes réponses

            $scoreModel = new Score();  // Instancie le modèle Score
            $existingScores = $scoreModel->getByUserId($userId); // Récupère les scores existants de l'utilisateur
            $existingScore = null; // Variable pour stocker un score existant du quiz

    // Vérifier si l'utilisateur a déjà un score au quiz
            foreach ($existingScores as $existing) {
                if ($existing['quiz_id'] == $quizId) {
                    $existingScore = $existing;
                    break;
                }
            }

    // Si un score existant est trouvé, il est comparé au nouveau score
            if ($existingScore && $existingScore['score'] < $score) {
    // Mettre à jour le score existant si le nouveau score est plus élevé
                $scoreModel->updateScore($userId, $score, $quizId, $totalCorrectQuestions);
                echo json_encode(['status' => 'success', 'message' => '🎉 Bravo ! Vous avez obtenu un meilleur score ! 🎉']);
                exit;
            }
            if ($existingScore && $existingScore['score'] >= $score) {
    // Indique que le nouveau score n'est pas meilleur
                echo json_encode(['status' => 'success', 'message' => '😕 Vous n\'avez pas amélioré votre score ! 😕']);
                exit;

            }
    // Si aucun score existant n'est trouvé, enregistre le nouveau score
            if ($scoreModel->saveScore($userId, $score,$quizId , $totalCorrectQuestions)) {
                echo json_encode(['status' => 'success', 'message' => ' ✅ Score sauvegardé avec succès.']);
            } else {
    // En cas d'échec de l'enregistrement
                echo json_encode(['status' => 'error', 'message' => ' ❌ Échec de \'enregistrement.']);
            }
        } else {
    // Message d'erreur si les données sont incomplètes ou invalides
            echo json_encode(['status' => 'error', 'message' => '⚠️ Entrée invalide.']);
        }
    }
    // Méthode pour afficher le classement
    public function showRanking() {
    // Récupérer les données du classement via RankingModel
        $ranking = $this->rankingModel->getRanking();
        $userModel = $this->userModel;

    // Transmettre les données du classement et du podium à la view
        require dirname(__DIR__) . '/views/templates/ranking.php';
    }
}
