<?php require dirname(__DIR__) . '/templates/header.php'; ?>
<link rel="stylesheet" href="public/css/styles-contact.css" type="text/css" media="all">

<script src="https://www.google.com/recaptcha/enterprise.js?render=6Lf6rK8qAAAAAGypquwa53yxoITA9UD5en6nYXP1"></script>
<script>
function onClick(e) {
    e.preventDefault();
    grecaptcha.enterprise.ready(async () => {
    const token = await grecaptcha.enterprise.execute('6Lf6rK8qAAAAAGypquwa53yxoITA9UD5en6nYXP1', {action: 'LOGIN'});
    });
}
</script>

<div class="margin">
    <h1>Nous contacter</h1>
    <div class="Form" id="Form">
        <form method="post" action="/contact">
            <?php $csrf_token = bin2hex(random_bytes(32));
            $_SESSION['csrf_token'] = $csrf_token; ?>
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

            <div class="Pseudo">
                <label for="Pseudo">Pseudo</label><br>
                <input type="text" name="Pseudo" id="Pseudo"
                    placeholder="Pseudo" class="champ personne"
                    maxlength="50" required>
            </div>

            <div class="Email">
                <label for="Email">Email</label><br>
                <input type="email" name="Email" id="Email"
                    placeholder="Jean-Bouzin-Le-Meilleur@gmail.com"
                    class="champ code" maxlength="100" required>
            </div>

            <div class="Object">
                <label for="Objet">Objet</label><br>
                <input type="text" name="Object" id="Objet"
                    placeholder="Objet du message" class="champ code"
                    maxlength="100" required>
            </div>

            <div class="LongText">
                <label for="Message">Message</label><br>
                <textarea name="Message" id="Message" class="LongText"
                    placeholder="Bonjour..." required
                    maxlength="1000"></textarea>
            </div>

            <!-- Remplacer la checkbox par un captcha -->
            <div class="g-recaptcha"
                data-sitekey="VOTRE_CLE_SITE_RECAPTCHA"></div>

            <button type="submit" class="Send">
                <i class="fa-solid fa-paper-plane"></i>
                <p class="txt-send">Envoyer</p>
            </button>
        </form>
    </div>
</div>
<?php require dirname(__DIR__) . '/templates/footer.php'; ?>