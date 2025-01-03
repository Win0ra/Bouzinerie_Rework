<?php
require_once dirname(__DIR__) . '/models/User.php';

class TemplateController {
    private $basePath;
    private $userModel;

    public function __construct() {
        $this->basePath = '/public/';
        $this->userModel = new User();

    }

    // Méthode pour le footer
    public function footer() {
        $footerLinks = [
            'Jouer' => $this->basePath . '#',
            'Contact' => $this->basePath . 'index.php?page=contact',
            'CGU' => $this->basePath . 'index.php?page=gcu',
            'Classement' => $this->basePath . 'index.php?page=ranking',
            'Mentions légales' => $this->basePath . 'index.php?page=legal-notices'
        ];
        return $footerLinks;
    }

    // Méthode pour la page de contact
    public function contact() {
        $pageTitle = "Contact - La Bouzinerie";
        
        require dirname(__DIR__) . '/views/templates/contact.php';
    }

    // Méthode pour les CGU
    public function cgu() {
        $pageTitle = "Conditions Générales d'Utilisation - La Bouzinerie";
        require dirname(__DIR__) . '/views/templates/gcu.php';
    }

    // Méthode pour la page des mentions légales
    public function legalNotices() {
        $pageTitle = "Mentions Légales - La Bouzinerie";
        require dirname(__DIR__) . '/views/templates/legal-notices.php';
    }
}
