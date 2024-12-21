<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/bouzinerie_rework/public/css/styles-footer.css" type="text/css" media="all">
</head>

<body>
    <div class="footer">
        <div class="foot-left">
            <p class="txt-foot"><a href="./index.php">Accueil</a></p>
            <p class="txt-foot"><a href="./beforegame.php">Jouer</a></p>
            <p class="txt-foot"><a href="javascript:void(0)">Créer un quiz</a></p>
            <p class="txt-foot"><a href="./ranking.php">Classement</a></p>
        </div>
        <div class="foot-center">
            <a href="./index.php"><img src="/bouzinerie_rework/public/img/logo_jaune.svg" alt="logo_la_bouzinerie">
            </a>
            <p class="txt-foot-center">La Bouzinerie by M2H</p>
        </div>
        <div class="foot-right">
            <div class="foot-right-column">
            <p class="txt-foot"><a href="./connexion.php">Connexion</a></p>
            <p class="txt-foot"><a href="./register.php">Inscription</a></p>
            <p class="txt-foot"><a href="./my-account.php">Mon compte</a></p>
        </div>
        <div class="foot-right-column">
        <?php
        $basePath = '/Bouzinerie_rework/';
        ?>
        <p class="txt-foot"><a href="<?php echo $basePath; ?>templates/contact.php">Contact</a></p>
        <p class="txt-foot"><a href="<?php echo $basePath; ?>templates/gcu.php">CGU</a></p>
        <p class="txt-foot"><a href="<?php echo $basePath; ?>templates/legal-notices.php">Mentions légales</a></p>

            </div>
        </div>
    </div>
</body>

</html>
