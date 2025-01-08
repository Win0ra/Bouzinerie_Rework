<?php
require_once dirname(__DIR__).'/models/Contact.php'; 

class ContactController {
    public function handleForm() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérification CSRF
            if (!$this->validateCSRFToken()) {
                throw new Exception('Token CSRF invalide');
            }
            
            $contact = new Contact();
            $contact->setPseudo($_POST['Pseudo'] ?? '');
            $contact->setEmail($_POST['Email'] ?? '');
            $contact->setObjet($_POST['Object'] ?? '');
            $contact->setMessage($_POST['Message'] ?? '');
            
            if ($contact->isValid()) {
                // Traitement du formulaire (envoi email, sauvegarde BDD, etc.)
                return ['success' => true];
            }
            return ['success' => false, 'errors' => 'Données invalides'];
        }
        return ['display' => true];
    }
    
    private function validateCSRFToken() {
        return isset($_POST['token']) && 
            $_POST['token'] === $_SESSION['token'];
    }
}