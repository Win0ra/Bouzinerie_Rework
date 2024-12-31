
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
            <p class="txt-foot"><a href="./beforegame">Jouer</a></p>
            <p class="txt-foot"><a href="/Bouzinerie_Rework/public/ranking">Classement</a></p>
        </div>
        <div class="foot-center">
            <a href="./index.php"><img src="/bouzinerie_rework/public/img/logo_jaune.svg" alt="logo_la_bouzinerie">
            </a>
            <p class="txt-foot-center">La Bouzinerie by M2H</p>
        </div>
        <div class="foot-right">
            <div class="foot-right-column">
            <p class="txt-foot"><a href="./login">Connexion</a></p>
            <p class="txt-foot"><a href="./register">Inscription</a></p>
            <p class="txt-foot"><a href="./my-account.php">Mon compte</a></p>
        </div>
        <div class="foot-right-column">
        <?php
        $basePath = '/Bouzinerie_rework/';
        ?>
        <p class="txt-foot"><a href="/Bouzinerie_Rework/public/contact">Contact</a></p>
        <p class="txt-foot"><a href="<?php echo $basePath; ?>gcu">CGU</a></p>
        <p class="txt-foot"><a href="<?php echo $basePath; ?>legal-notices.">Mentions légales</a></p>

            </div>
        </div>
    </div>
</body>

</html>
