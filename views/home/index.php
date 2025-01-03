<?php require dirname(__DIR__) . '/templates/header.php'; ?>

<div class="">
    <h1>La Bouzinerie</h1>
    <?php
    // Transmettre les données à content.php
    require dirname(__DIR__) . '/templates/content.php';
    ?><br /><br /><br />
    <?php
    require dirname(__DIR__) . '/templates/podium.php';
    ?>
</div>

<a href="/Bouzinerie_Rework/public/ranking"><button class="ranking"><i class="fa-solid fa-ranking-star"></i>
        <p class="txt-ranking">Voir le Classement</p>
    </button></a>
    
<?php require dirname(__DIR__) . '/templates/footer.php'; ?>