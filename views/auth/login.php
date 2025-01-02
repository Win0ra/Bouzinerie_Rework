<?php require dirname(__DIR__) . '/templates/header.php'; ?>

<link rel="stylesheet" href="/bouzinerie_rework/public/css/styles-login.css" type="text/css" media="all">
<script src="https://accounts.google.com/gsi/client" async defer></script>

<script>
    function handleCredentialResponse(response) {
        const token = response.credential;
        fetch('/api/auth/google', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    token
                }),
            })
            .then(response => response.json())
            .then(data => console.log('Réponse du serveur :', data))
            .catch(error => console.error('Erreur :', error));
    }
</script>


    <div class="content">
        <div class="card">
            <div class="card-header">
                <h1 class="text-center">Connexion</h1>
            </div>
            <!-- <div class="card-body"> -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php
                    echo htmlspecialchars($_SESSION['success']);
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="index.php?page=login" novalidate>
                <div class="left">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email"
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                        required>
                </div>
                <div class="left">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="checkbox">
                    <input type="checkbox" name="checkbox" id="checkbox">
                    <p class="souvenir"> Se souvenir de moi...</p><br />
                    <p class="mdp-oublie"><a href="#">Mot de passe oublié ?</a></p>
                </div>

                <button type="submit" class="connexion">Se connecter</button>
            </form>

            <div class="no-compte">
                <p>Pas encore inscrit? 
                <button type="submit" class="register"><a href="index.php?page=register">S'inscrire</a></button>   
            </div>
        </div>
        <div class="connex-rs">
            <!-- Bouton Google Sign-In -->
            <div id="g_id_onload"
                data-client_id="1034339065791-3thgahi0eg6f1bbvgets1ljnvvldmkn4.apps.googleusercontent.com"
                data-callback="handleCredentialResponse">
            </div>
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
<!-- </div> -->
<?php require dirname(__DIR__) . '/templates/footer.php'; ?>