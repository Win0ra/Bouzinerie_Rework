<?php
require_once dirname(__DIR__) . '/models/User.php';
require_once dirname(__DIR__) . '/models/RankingModel.php';

class HomeController {
    private $userModel;
    private $rankingModel;

    public function __construct($pdo) {
        $this->userModel = new User();
        $this->rankingModel = new RankingModel($pdo);
    }

    public function index() {
        $ranking = $this->rankingModel->getRanking();
    
        // Debug
        error_log('Données du ranking avant inclusion de la vue : ' . print_r($ranking, true));
    
        // Extraire les variables pour la vue
        extract(['ranking' => $ranking]);
    
        // Inclure la vue
        require dirname(__DIR__) . '/views/home/index.php';
    }
    
}
