<?php
require_once dirname(__DIR__) . '/models/User.php';

class HomeController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function index() {
        // Fetch leaderboard data
        $leaderboard = $this->userModel->getLeaderboard();
        $userModel = $this->userModel;

        // Pass leaderboard data to the view
        require dirname(__DIR__) . '/views/home/index.php';
    }
}

