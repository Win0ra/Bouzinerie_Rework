<?php require dirname(__DIR__). '/templates/header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nous contacter - La Bouzinerie</title>
    <link rel="stylesheet" href="/bouzinerie_rework/public/css/styles-contact.css" type="text/css" media="all">
    <script src="https://kit.fontawesome.com/e98829b701.js" crossorigin="anonymous"></script>
</head>

<body>
<div class="margin">
    <h1>Nous contacter</h1>
    <div class="Form" id="Form">
        <form name="Contact" method="post" action="/bouzinerie_rework/public/contact-handler.php" enctype="application/x-www-form-urlencoded">
            <div class="FirstName">
                <h2>Prénom</h2><br>
                <input type="text" name="FirstName" id="Prenom" placeholder="Jean-Bouzin-Le-Meilleur" class="champ personne" required>
            </div>

            <div class="LastName">
                <h2>Nom</h2><br>
                <input type="text" name="LastName" id="Nom" placeholder="Jean-Bouzin-Le-Meilleur" class="champ personne" required>
            </div>

            <div class="Email">
                <h2>Email</h2><br>
                <input type="email" name="Email" id="Email" placeholder="Jean-Bouzin-Le-Meilleur@gmail.com" class="champ code" required>
            </div>

            <div class="Object">
                <h2>Objet</h2><br>
                <input type="text" name="Object" id="Objet" placeholder="Objet du message" class="champ code" required>
            </div>

            <div class="LongText">
                <h2>Message</h2><br>
                <textarea name="Message" class="LongText" placeholder="Bonjour..." required></textarea>
            </div>

            <label>
                <input type="checkbox" id="checkbox" name="Confidentiality" value="oui" required> Je ne suis pas un robot
            </label>
            <button type="submit" class="Send"><i class="fa-solid fa-paper-plane"></i>
                <p class="txt-send">Envoyer</p>
            </button>
        </form>
    </div>
</div>
</body>

</html>
<?php require dirname(__DIR__). '/templates/footer.php'; ?>
