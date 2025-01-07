<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/styles-navbar.css" type="text/css" media="all"> 
    <?php if (isset($_GET["page"] ) && $_GET["page"] == "quiz")  : ?> 
    <link rel="stylesheet" href="public/css/styles-game.css" type="text/css" media="all">
    <?php endif; ?>
    <?php if (isset($_GET["page"] ) && $_GET["page"] == "contact")  : ?> 
    <link rel="stylesheet" href="public/css/styles-contact.css" type="text/css" media="all">
    <?php endif; ?>
    <script src="https://kit.fontawesome.com/e98829b701.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


</head>


    <div class="Navbar">
        <ul>
            <li><a href="index.php?page=home">Accueil</a></li>
            <?php if (isset($_SESSION['user_id'])) : ?>

                <li class="li-chevron">
                    <a href="index.php?page=ranking" class="a-ranking" id="ranking">Classement</a>

                </li>
                <?php if (isset($userModel) && $userModel->isAdmin($_SESSION['user_id'])): ?>
                    <li><a href="index.php?page=admin">Panneau Admin</a></li>

                <?php endif; ?>

                <li><a href="index.php?page=logout">Déconnexion</a></li>

            <?php else : ?>
                <li><a href="index.php?page=login">Connexion</a></li>
                <li><a href="index.php?page=register">Inscription</a></li>
                <li>
                    <a href="index.php?page=ranking" class="a-ranking" id="ranking">Classement</a>

                </li>
            <?php endif; ?>
        </ul>
        <div class="logo"><a href="index.php?page=home"><img src="public/img/logo_bleu.svg" alt="logo_la_bouzinerie">
        </a></div>
    </div>
    <span>
    <?php if (isset($userModel) && isset($_SESSION['user_id']) && $userModel->isAdmin($_SESSION['user_id'])): ?>
    Vous êtes bien connecté 
    <?php endif; ?>

    <?php 
        if (isset($_SESSION['user_id']) && isset($userModel)) {
            echo htmlspecialchars($userModel->getUsernameById($_SESSION['user_id']), ENT_QUOTES, 'UTF-8');
        } else {
            echo '';
        }
    ?>
</span>
    
    </div>


