<?php 
$recaptcha_secret = "recaptcha_secret_key"; // A remplacer par la clé secrète
$response = $_POST['g-recaptcha-response'];
$verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$response}");
$captcha_success = json_decode($verify);

if ($captcha_success->success==false) {
    // Le CAPTCHA n'est pas validé
    echo "Erreur : veuillez valider le CAPTCHA";
} else {
    // Le CAPTCHA est validé, continue le traitement
}
?>