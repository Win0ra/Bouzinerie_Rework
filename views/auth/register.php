<?php require dirname(__DIR__).'/templates/header.php'; ?>

<link rel="stylesheet" href="public/css/styles-register.css" type="text/css" media="all">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
function onClick(e) {
    e.preventDefault();
    grecaptcha.enterprise.ready(async () => {
        const token = await grecaptcha.enterprise.execute('6LcAZbMqAAAAAFSL0OFtB6cATsyL0DRXTDRNUo4h', {action: 'LOGIN'});
        console.log('Token:', token);
    });
}
</script>

<div class="content">
    <div class="card">
        <div class="card-header">
            <h1 class="text-center">Inscription</h1>
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
                <div class="left">
                    <label for="pseudo">Pseudo</label>
                    <input type="pseudo" class="form-control" id="pseudo" name="pseudo"
                        value="<?php echo isset($_POST['pseudo']) ? htmlspecialchars($_POST['pseudo']) : ''; ?>"
                        required>
                </div>
                <div class="left">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                        required>
                </div>
                <div class="left">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <small class="form-text text-muted">Le mot de passe doit contenir au moins 6 caractères</small><br/><br/>
                <div class="left">
                    <label for="confirm_password">Confirmer le mot de passe</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="register"><i class="fa-solid fa-pen-to-square" id="i-white"></i>S'inscrire</button>
            </form>
            <div class="checkbox">
                <input type="checkbox" name="checkbox" id="checkbox" required>
                <p class="cgu">J'accepte les Conditions Générales d'Utilisation et la Politique de Confidentialité.<br/>
                    Je reconnais que mes données seront traitées conformément à cette politique.<br/>
                    Je comprends que je peux me désinscrire à tout moment.</p>
            </div><br/>

    <form action="?" method="POST">
        <div class="g-recaptcha" data-sitekey="6LcAZbMqAAAAAFSL0OFtB6cATsyL0DRXTDRNUo4h"></div>
        <br/>
        <input type="submit" value="Submit">
    </form>
            <div class="mt-3 text-center">
                <p>Déjà inscrit? 
                <button type="submit" class="login"><a href="index.php?page=login">Se connecter</a></button></p>   
            </div>
        </div>
    </div>
</div>
<?php require dirname(__DIR__). '/templates/footer.php'; ?> 