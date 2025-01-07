
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styles-footer.css" type="text/css" media="all">
</head>


    <footer class="footer">
        <div class="foot-left">
            <p class="txt-foot" id="foot"><a href="/index.php?page=home">Accueil</a></p>
            <?php if (isset($userModel) && $userModel->isAdmin($_SESSION['user_id'])): ?>
                    <p class="txt-foot" id="foot"><a href="/index.php?page=admin">Panneau Admin</a></p>
            <?php endif; ?>
            <?php if (!isset($_SESSION['user_id'])) : ?>

                <p class="txt-foot" id="foot"><a href="/index.php?page=register">Inscription</a></p>
                <p class="txt-foot" id="foot"><a href="/index.php?page=login">Connexion</a></p>
            <?php endif; ?>

            <p class="txt-foot" id="foot"><a href="/index.php?page=ranking">Classement</a></p>

        </div>

        <div class="foot-center">
            <a href="/index.php?page=home">
                <img src="/img/logo_jaune.svg" alt="logo_la_bouzinerie">
            </a>
            <br/>
            <p class="txt-foot-center">La Bouzinerie by M2H<br/>Tous droits réservés &#169;<br/></p>
            <?= date('Y') ?>
        </div>

        <div class="foot-right">
            <div class="foot-right-column">
                <p class="txt-foot" id="foot"><a href="/index.php?page=contact">Contact</a></p>
                <p class="txt-foot" id="foot"><a href="/index.php?page=gcu">CGU</a></p>
                <p class="txt-foot" id="foot"><a href="/index.php?page=legal-notices">Mentions légales</a></p>
            </div>
        </div>
    </footer>

