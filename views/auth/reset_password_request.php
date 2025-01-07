<?php require dirname(__DIR__) . '/templates/header.php'; // Inclusion de l'en-tête ?>
<link rel="stylesheet" href="public/css/styles-login.css" type="text/css" media="all">

<!-- Script Google Sign-In pour gérer l'authentification via Google -->
<script src="https://accounts.google.com/gsi/client" async defer></script>

    <div class="content">
        <h1>Réinitialisation de mot de passe</h1><br/>
    <div class="container">  
        <form action="/index.php?page=send-reset-link" method="POST">
            <label for="email">Entrez votre adresse email :</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Envoyez le lien</button>
        </form>
    </div>
</div>

