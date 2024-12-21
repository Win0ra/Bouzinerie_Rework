<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="/bouzinerie_rework/public/css/styles-navbar.css" type="text/css" media="all">
    <!-- <link rel="stylesheet" href="<?php dirname(__DIR__) ?>/public/css/styles-navbar.css" type="text/css" media="all">     -->
    <script src="https://kit.fontawesome.com/e98829b701.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


</head>

<body>
    <div class="Navbar">
        <ul>
            <li><a href="index.php?page=home">Accueil</a></li>
            <?php if (isset($_SESSION['user_id'])) : ?>

                <li><a href="index.php?page=categories">Jouer</a></li>
                <li class="li-chevron">
                    <a href="index.php?page=home" class="a-ranking" id="ranking">Classement</a>
                    <i class="fa-solid fa-chevron-right arrow-dropdown"></i>
                </li>
                <a href="#" class="dropdown">Classement par thèmes</a>
                <?php if ($userModel->isAdmin($_SESSION['user_id'])): ?>
                    <li><a href="index.php?page=admin">Panneau Admin</a></li>

                <?php endif; ?>

                <!-- <li><a href="#">Mon Compte</a></li> -->
                <li><a href="index.php?page=logout">Déconnexion</a></li>

            <?php else : ?>
                <li><a href="index.php?page=login">Connexion</a></li>
                <li><a href="index.php?page=register">Inscription</a></li>
                <li class="li-chevron">
                    <a href="ranking.php" class="a-ranking" id="ranking">Classement</a>
                    <i class="fa-solid fa-chevron-right arrow-dropdown"></i>
                </li>
                <a href="#" class="dropdown">Classement par thèmes</a>
            <?php endif; ?>
        </ul>
        <div class="logo"><a href="index.php?page=home"><img src="/bouzinerie_rework/public/img/logo_bleu.svg" alt="logo_la_bouzinerie">
        </a></div>
    </div>
    <!-- TO DO Ajouter la phrase  Connecté en tant que Nom prenom -->
    </div>
    <script src="/bouzinerie/public/js/script-navbar.js"></script>


</body>

</html>