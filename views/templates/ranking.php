<?php 
require dirname(__DIR__). '/templates/header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classement Général</title>
    <link rel="stylesheet" href="/bouzinerie_rework/public/css/styles-ranking.css" type="text/css" media="all">
    <script src="https://kit.fontawesome.com/e98829b701.js" crossorigin="anonymous"></script>
</head>

<body>

    <div class="margin">
        <h1>Classement Général</h1>
        <!-- Podium -->
        <div class="Blocks">
        <?php require dirname(__DIR__) . '/templates/podium.php'; ?>
        </div><br/><br/><br/>

        <!-- Classement complet -->
        <div class="General-Ranking">
            <div class="Ranking-List">
                <h3 class="h3-position">Position</h3>
                <h3 class="h3-pseudo">Pseudo</h3>
                <h3 class="h3-score">Score</h3>
            </div>
            <?php if (isset($ranking) && !empty($ranking)): ?>
                <?php foreach ($ranking as $index => $player): ?>
                    <ul class="List-group-horizontal">
                        <li class="Position"><?= $index + 1 ?></li>
                        <li class="Pseudo"><?= htmlspecialchars($player['pseudo'] ?? 'Inconnu') ?></li>
                        <li class="Score"><?= isset($player['total_score']) ? number_format($player['total_score']) : 'N/A' ?></li>
                    </ul>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun classement disponible.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
<?php require dirname(__DIR__). '/templates/footer.php'; ?>
