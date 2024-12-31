<?php
require_once dirname(__DIR__) . '/models/RankingModel.php';

class RankingController
{
    private $rankingModel;

    public function __construct($pdo)
    {
        $this->rankingModel = new RankingModel($pdo);
    }

    public function showRanking() {

        // Fetch podium data
        $ranking = $this->rankingModel->getRanking();

        // Pass leaderboard and podium data to the view
        require dirname(__DIR__) . '/views/templates/ranking.php';
    }
}
