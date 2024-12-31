<link rel="stylesheet" href="/bouzinerie_rework/public/css/styles-podium.css" type="text/css" media="all">
<!-- Podium -->
<div class="margin">
<div class="Blocks">
    <?php if (isset($ranking) && count($ranking) >= 3): ?>
        <div class="Second">
            <i class="fa-sharp fa-solid fa-trophy" id="second"></i>
            <div class="SecondBlock">
                <p class="p-podium"><?= htmlspecialchars($ranking[1]['pseudo']." : ".htmlspecialchars($ranking[1]['total_score'] ?? 'Inconnu')) ?></p>
            </div>
        </div>
        <div class="First">
            <i class="fa-sharp fa-solid fa-trophy" id="first"></i>
            <div class="FirstBlock">
                <p class="p-podium"><?= htmlspecialchars($ranking[0]['pseudo']." : ".htmlspecialchars($ranking[0]['total_score'] ?? 'Inconnu')) ?></p>
            </div>
        </div>
        <div class="Third">
            <i class="fa-sharp fa-solid fa-trophy" id="third"></i>
            <div class="ThirdBlock">
                <p class="p-podium"><?= htmlspecialchars($ranking[2]['pseudo']." : ".htmlspecialchars($ranking[2]['total_score'] ?? 'Inconnu')) ?></p>
            </div>
        </div>
    <?php else: ?>
        <p>Aucun classement disponible.</p>
    <?php endif; ?>
</div>


</div> 