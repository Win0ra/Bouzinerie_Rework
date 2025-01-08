<?php
require_once  dirname(__DIR__).'/config/Database.php'; // Inclusion de la configuration de la base de données
class Contact {
    private $pseudo;
    private $email;
    private $objet;
    private $message;
    
    public function setPseudo($pseudo) {
        $this->pseudo = strip_tags(trim($pseudo));
    }
    
    public function setEmail($email) {
        $this->email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    }
    
    public function setObjet($objet) {
        $this->objet = strip_tags(trim($objet));
    }
    
    public function setMessage($message) {
        $this->message = strip_tags(trim($message));
    }
    
    public function isValid() {
        return !empty($this->pseudo) 
            && filter_var($this->email, FILTER_VALIDATE_EMAIL)
            && !empty($this->objet)
            && strlen($this->message) >= 10;
    }
}