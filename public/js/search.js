// Classe pour gérer la vue de recherche de quiz
class QuizSearchView {
    constructor() {
        // Récupère les éléments DOM nécessaires
        this.searchBar = document.getElementById('searchBar'); // Barre de recherche
        this.resultsDiv = document.getElementById('results');  // Conteneur pour afficher les résultats
        this.contentDiv = document.querySelector('.content');  // Conteneur pour le contenu par défaut
        
        // Liaison des événements
        this.bindEvents();
    }

    // Lie les événements à la barre de recherche
    bindEvents() {
        let searchTimeout; // Permet de limiter les recherches fréquentes (debounce)
        
        // Écoute les saisies dans la barre de recherche
        this.searchBar.addEventListener('input', () => {
            clearTimeout(searchTimeout); // Annule le dernier timer
            searchTimeout = setTimeout(() => this.performSearch(), 300); // Lance une recherche après 300 ms
        });
    }

    // Effectue une recherche en fonction de la saisie utilisateur
    async performSearch() {
        const query = this.searchBar.value.trim(); // Récupère et nettoie la saisie utilisateur
        
        // Si la saisie est vide, nettoie les résultats et restaure le contenu par défaut
        if (query.length === 0) {
            this.clearResults();
            return;
        }

        try {
            // Effectue une requête pour récupérer les quiz correspondant à la recherche
            const response = await fetch(`index.php?action=search&q=${encodeURIComponent(query)}`);
            if (!response.ok) throw new Error(response.statusText); // Vérifie si la requête a réussi
            
            const data = await response.json(); // Convertit la réponse en JSON
            this.displayResults(data); // Affiche les résultats
        } catch (error) {
            // Affiche un message d'erreur en cas de problème
            this.showError('Une erreur est survenue lors de la recherche, merci de réessayer');
        }
    }

    // Efface les résultats affichés et restaure le contenu par défaut
    clearResults() {
        this.resultsDiv.innerHTML = ''; // Vide le conteneur des résultats
        this.contentDiv.style.display = 'flex'; // Affiche le contenu par défaut
    }

    // Affiche les résultats de la recherche
    displayResults(data) {
        this.contentDiv.style.display = 'none'; // Masque le contenu par défaut
        
        // Si aucun résultat n'est trouvé, affiche un message
        if (data.length === 0) {
            this.resultsDiv.innerHTML = '<p class="no-results">Aucun quiz trouvé.</p>';
            return;
        }

        // Génère le HTML pour chaque résultat
        const resultsHTML = data.map(quiz => `
            <div class="card">
                <div class="cards">
                    <h5 class="card-title">${this.escapeHtml(quiz.title)}</h5>
                    ${quiz.image ? `
                        <img class="card-img-top" 
                        src="/views/uploads/categories/${this.escapeHtml(quiz.image)}" 
                        alt="Image de ${this.escapeHtml(quiz.title)}" 
                        width="50">
                    ` : ''}
                    <a href="index.php?page=quiz&category=${quiz.id}" class="btn btn-primary">
                        Jouer
                    </a>
                </div>
            </div>
        `).join('');

        // Insère les résultats dans le conteneur
        this.resultsDiv.innerHTML = `
            <div class="search-results content">
                ${resultsHTML}
            </div>
        `;
    }

    // Affiche un message d'erreur
    showError(message) {
        // Insère le message d'erreur dans le conteneur des résultats
        this.resultsDiv.innerHTML = `<p class="error">${this.escapeHtml(message)}</p>`;
    }

    // Échappe les caractères HTML pour éviter les failles XSS
    escapeHtml(str) {
        const div = document.createElement('div'); // Crée un élément temporaire
        div.textContent = str; // Assigne le texte brut
        return div.innerHTML; // Retourne le texte échappé
    }
}

// Initialisation de la vue de recherche lorsque le DOM est chargé
document.addEventListener('DOMContentLoaded', () => {
    new QuizSearchView(); // Crée une instance de la classe QuizSearchView
});
