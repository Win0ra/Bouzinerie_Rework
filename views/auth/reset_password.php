<?php require dirname(__DIR__) . '/templates/header.php'; // Inclusion de l'en-tête ?>

<!-- Lien vers la feuille de style spécifique pour la page de connexion -->

<div class="container">
        <h2>Reset Password</h2>
        <form action="/index.php?page=update-password" method="POST">
            <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <button type="submit">Reset Password</button>
        </form>
    </div>
<?php require dirname(__DIR__) . '/templates/footer.php'; // Inclusion du pied de page ?>
