
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/styles-footer.css" type="text/css" media="all">
</head>


    <footer class="footer">
        <div class="foot-left">
            <p class="txt-foot" id="foot"><a href="/public/index.php?page=home">Accueil</a></p>
            <p class="txt-foot" id="foot"><a href="/public/index.php?page=categories">Jouer</a></p>
            <p class="txt-foot" id="foot"><a href="/public/index.php?page=ranking">Classement</a></p>
        </div>

        <div class="foot-center">
            <a href="/public/index.php?page=home">
                <img src="/public/img/logo_jaune.svg" alt="logo_la_bouzinerie">
            </a>
            <br/>
            <p class="txt-foot-center">La Bouzinerie by M2H<br/>Tous droits réservés &#169;<br/></p>
            <?= date('Y') ?>
        </div>

        <div class="foot-right">
            <div class="foot-right-column">
                <p class="txt-foot" id="foot"><a href="/public/index.php?page=login">Connexion</a></p>
                <p class="txt-foot" id="foot"><a href="/public/index.php?page=register">Inscription</a></p>
                <p class="txt-foot" id="foot"><a href="/public/my-account.php">Mon compte</a></p>
            </div>

            <div class="foot-right-column">
                <p class="txt-foot" id="foot"><a href="/public/index.php?page=contact">Contact</a></p>
                <p class="txt-foot" id="foot"><a href="/public/index.php?page=gcu">CGU</a></p>
                <p class="txt-foot" id="foot"><a href="/public/index.php?page=legal-notices">Mentions légales</a></p>
            </div>
        </div>
    </footer>

