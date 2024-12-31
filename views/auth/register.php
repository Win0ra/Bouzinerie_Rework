<?php require dirname(__DIR__).'/templates/header.php'; ?>

<link rel="stylesheet" href="/bouzinerie_rework/public/css/styles-register.css" type="text/css" media="all">

<div class="content mt-5">
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">Inscription</h3>
        </div>
        <div class="card-body">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="index.php?page=register" novalidate>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                        required>
                </div>
                <div class="form-group mb-3">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <small class="form-text text-muted">Le mot de passe doit contenir au moins 6 caractères</small>
                </div>
                <div class="form-group mb-3">
                    <label for="confirm_password">Confirmer le mot de passe</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="register">S'inscrire</button>
            </form>

            <div class="mt-3 text-center">
                <p>Déjà inscrit? <a href="index.php?page=login">Se connecter</a></p>
            </div>
        </div>
    </div>
</div>
<?php require dirname(__DIR__). '/templates/footer.php'; ?> 