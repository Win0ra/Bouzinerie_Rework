<?php
require_once dirname(__DIR__) . '/models/RankingModel.php';
require_once dirname(__DIR__) . '/models/User.php';
require_once dirname(__DIR__) . '/models/Score.php'; // Include Score model

class RankingController
{
    private $rankingModel;
    private $userModel;

    public function __construct($pdo)
    {
        $this->rankingModel = new RankingModel($pdo);
        $this->userModel = new User();
    }

    public function saveScore() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['userId'], $data['score'], $data['quizId'], $data['totalCorrectQuestions'])) {
            $userId = $data['userId'];
            $score = $data['score'];
            $quizId = $data['quizId'];
            $totalCorrectQuestions = $data['totalCorrectQuestions'];

            $scoreModel = new Score();
            if ($scoreModel->saveScore($userId, $score,$quizId , $totalCorrectQuestions)) {
                echo json_encode(['status' => 'success', 'message' => 'Score saved successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to save score.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid input.']);
        }
    }

    public function showRanking() {
        // Fetch podium data
        $ranking = $this->rankingModel->getRanking();
        $userModel = $this->userModel;

        // Pass leaderboard and podium data to the view
        require dirname(__DIR__) . '/views/templates/ranking.php';
    }
}
