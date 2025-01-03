<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération des données du formulaire
    $firstName = htmlspecialchars($_POST['FirstName'] ?? '');
    $lastName = htmlspecialchars($_POST['LastName'] ?? '');
    $email = htmlspecialchars($_POST['Email'] ?? '');
    $object = htmlspecialchars($_POST['Object'] ?? '');
    $message = htmlspecialchars($_POST['Message'] ?? '');

    // Validation des champs
    if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($object) && !empty($message)) {
        // Exemple : Sauvegarde ou envoi par email
        $to = "contact.bouzinerie@gmail.com";
        $subject = "Contact : $object";
        $body = "Prénom : $firstName\nNom : $lastName\nEmail : $email\nMessage : $message";
        $headers = "From: $email";

        if (mail($to, $subject, $body, $headers)) {
            echo "Merci pour votre message ! Nous vous répondrons dès que possible.";
        } else {
            echo "Une erreur s'est produite lors de l'envoi du message. Veuillez réessayer.";
        }
    } else {
        echo "Veuillez remplir tous les champs obligatoires.";
    }
} else {
    echo "Méthode non autorisée.";
}
?>
