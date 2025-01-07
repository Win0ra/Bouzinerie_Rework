<?php require dirname(__DIR__) . '/templates/header.php'; // Inclusion de l'en-tête ?>

<!-- Lien vers la feuille de style spécifique pour la page de connexion -->

<!-- Script Google Sign-In pour gérer l'authentification via Google -->
<script src="https://accounts.google.com/gsi/client" async defer></script>

    <div class="container">
        <h2>Reset Password</h2>
        <form action="/index.php?page=send-reset-link" method="POST">
            <label for="email">Enter your email address:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Send Reset Link</button>
        </form>
    </div>
<?php require dirname(__DIR__) . '/templates/footer.php'; // Inclusion du pied de page ?>
