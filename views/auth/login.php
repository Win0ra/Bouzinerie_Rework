<?php require dirname(__DIR__) . '/templates/header.php'; // Inclusion de l'en-tête ?>

<!-- Lien vers la feuille de style spécifique pour la page de connexion -->
<link rel="stylesheet" href="/public/css/styles-login.css" type="text/css" media="all">

<!-- Script Google Sign-In pour gérer l'authentification via Google -->
<script src="https://accounts.google.com/gsi/client" async defer></script>

<script>
    // Fonction pour gérer la réponse des identifiants Google
    function handleCredentialResponse(response) {
        const token = response.credential; // Récupère le jeton Google
        fetch('/api/auth/google', { // Envoie une requête à l'API backend pour authentifier l'utilisateur
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json', // Spécifie que le contenu est au format JSON
                },
                body: JSON.stringify({ token }), // Envoie le jeton dans le corps de la requête
            })
            .then(response => response.json()) // Parse la réponse JSON
            .then(data => console.log('Réponse du serveur :', data)) // Affiche la réponse dans la console
            .catch(error => console.error('Erreur :', error)); // Gère les erreurs
    }
</script>

<div class="content">
    <div class="card">
        <div class="card-header">
            <h1 class="text-center">Connexion</h1> <!-- Titre de la page -->
        </div>

        <!-- Affichage des erreurs s'il y en a -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); // Sécurise l'affichage des erreurs ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Affichage des messages de succès si présents -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php
                echo htmlspecialchars($_SESSION['success']); // Sécurise l'affichage du message
                unset($_SESSION['success']); // Supprime le message après affichage
                ?>
            </div>
        <?php endif; ?>

        <!-- Formulaire de connexion -->
        <form method="POST" action="index.php?page=login" novalidate>
            <div class="left">
                <!-- Champ pour l'adresse email -->
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                    required>
            </div>
            <div class="left">
                <!-- Champ pour le mot de passe -->
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="checkbox">
                <!-- Option pour se souvenir de l'utilisateur -->
                <input type="checkbox" name="checkbox" id="checkbox">
                <p class="souvenir"> Se souvenir de moi...</p><br />
                <p class="mdp-oublie"><a href="#">Mot de passe oublié ?</a></p> <!-- Lien pour récupérer le mot de passe -->
            </div>

            <!-- Bouton pour soumettre le formulaire -->
            <button type="submit" class="connexion">Se connecter</button>
        </form>

        <!-- Lien pour s'inscrire si l'utilisateur n'a pas de compte -->
        <div class="no-compte">
            <p>Pas encore inscrit? 
            <button type="submit" class="register"><a href="index.php?page=register">S'inscrire</a></button>   
        </div>
    </div>

    <!-- Section pour la connexion via Google -->
    <div class="connex-rs">
        <!-- Initialisation de Google Sign-In -->
        <div id="g_id_onload"
            data-client_id="1034339065791-3thgahi0eg6f1bbvgets1ljnvvldmkn4.apps.googleusercontent.com"
            data-callback="handleCredentialResponse">
        </div>
        <!-- Bouton Google Sign-In -->
        <div class="g_id_signin"
            data-type="standard"
            data-shape="rectangular"
            data-theme="outline"
            data-text="sign_in_with"
            data-size="large"
            data-logo_alignment="middle">
        </div>
    </div>
</div>

<?php require dirname(__DIR__) . '/templates/footer.php'; // Inclusion du pied de page ?>
