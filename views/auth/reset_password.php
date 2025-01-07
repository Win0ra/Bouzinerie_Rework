<?php require dirname(__DIR__) . '/templates/header.php'; // Inclusion de l'en-tête ?>

<link rel="stylesheet" href="public/css/styles-register.css" type="text/css" media="all">

<div class="content">
        <h1>Réinitialisation de mot de passe</h1><br/>
        <form action="/index.php?page=update-password" method="POST">
            <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
            <label for="password">Nouveau mot de passe :</label><br/>
            <input type="password" id="password" name="password" required>
            <label for="confirm_password">Confirmez le nouveau mot de passe :</label><br/>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <button type="submit">Réinitialisation</button>
        </form>
    </div>

