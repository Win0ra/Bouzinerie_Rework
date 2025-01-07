<?php
require_once dirname(__DIR__) . '/models/User.php'; // Inclusion du modèle User pour interagir avec les utilisateurs

class TemplateController {
    // Propriétés pour le chemin de base et le modèle utilisateur
    private $basePath;
    private $userModel;

    // Constructeur : initialise les propriétés
    public function __construct() {
        $this->basePath = '';              // Définit le chemin de base pour les URLs publiques
        $this->userModel = new User();             // Instancie le modèle User
    }

    // Méthode pour générer les liens du footer
    public function footer() {
        // Définition des liens du footer et leurs URLs associées
        $footerLinks = [
            'Jouer' => $this->basePath . '#',                              // Lien vers la page de jeu (placeholder ici)
            'Contact' => $this->basePath . 'index.php?page=contact',       // Lien vers la page de contact
            'CGU' => $this->basePath . 'index.php?page=gcu',               // Lien vers les Conditions Générales d'Utilisation
            'Classement' => $this->basePath . 'index.php?page=ranking',    // Lien vers la page de classement
            'Mentions légales' => $this->basePath . 'index.php?page=legal-notices' // Lien vers les mentions légales
        ];

        // Retourne les liens du footer sous forme de tableau
        return $footerLinks;
    }

    // Méthode pour afficher la page de contact
    public function contact() {
        $pageTitle = "Contact - La Bouzinerie"; // Titre de la page de contact
        $userModel = $this->userModel;

        // Inclut la vue associée à la page de contact
        require dirname(__DIR__) . '/views/templates/contact.php';
    }

    // Méthode pour afficher les Conditions Générales d'Utilisation (CGU)
    public function cgu() {
        $pageTitle = "Conditions Générales d'Utilisation - La Bouzinerie"; // Titre de la page des CGU
        $userModel = $this->userModel;

        // Inclut la vue associée aux CGU
        require dirname(__DIR__) . '/views/templates/gcu.php';
    }

    // Méthode pour afficher la page des mentions légales
    public function legalNotices() {
        $pageTitle = "Mentions Légales - La Bouzinerie"; // Titre de la page des mentions légales
        $userModel = $this->userModel;

        // Inclut la vue associée aux mentions légales
        require dirname(__DIR__) . '/views/templates/legal-notices.php';
    }
}
