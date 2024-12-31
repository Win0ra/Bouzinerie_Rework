<?php
require_once dirname(__DIR__) . '/config/Database.php';
require_once dirname(__DIR__) . '/models/RankingModel.php';
require_once dirname(__DIR__) . '/controllers/RankingController.php';

// Créer une instance de Database
$database = new Database();

// Obtenir la connexion
$conn = $database->getConnection();

if ($conn) {
    echo "Connexion à la base de données réussie.<br>";

    // Instancier RankingModel et RankingController
    $model = new RankingModel($conn);
    $controller = new RankingController($conn);

    // Tester RankingController et afficher $ranking
    try {
        ob_start(); // Capture de sortie pour ne pas interférer avec les éventuelles sorties dans la vue

        $controller->showRanking();

        $output = ob_get_clean(); // Récupérer la sortie
        echo $output;
    } catch (Exception $e) {
        echo "Erreur lors de l'exécution du contrôleur : " . $e->getMessage();
    }
} else {
    echo "Échec de connexion à la base de données.";
}

?>
