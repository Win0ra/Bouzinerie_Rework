// Ajoute un écouteur d'événement sur la barre de recherche pour détecter les saisies utilisateur
document.getElementById('searchBar').addEventListener('input', async function() {
    const query = this.value.trim(); // Récupère et nettoie la valeur de l'input (supprime les espaces inutiles)
    
    // Si la barre de recherche est vide, efface les résultats et arrête le traitement
    if (!query) {
        document.getElementById('results').innerHTML = ''; // Vide le conteneur des résultats
        return; // Arrête l'exécution
    }

    try {
        // Effectue une requête `fetch` pour chercher les données correspondant à la requête
        const response = await fetch(`/ranking/search?q=${encodeURIComponent(query)}`); 
        // Transforme la réponse en JSON
        const data = await response.json();
        // Affiche les résultats dans le conteneur prévu
        displayResults(data);
    } catch (error) {
        // Log l'erreur dans la console en cas de problème avec la requête
        console.error('Erreur de recherche:', error);
    }
});

// Fonction pour afficher les résultats de la recherche
function displayResults(data) {
    const resultsDiv = document.getElementById('results'); // Récupère le conteneur des résultats

    // Si des résultats sont disponibles, génère une liste d'éléments <p> pour chaque pseudo
    // Sinon, affiche un message indiquant qu'aucun résultat n'a été trouvé
    resultsDiv.innerHTML = data.length 
        ? data.map(player => `<p>${player.pseudo}</p>`).join('') // Génère le HTML pour chaque pseudo
        : '<p>Aucun résultat trouvé.</p>'; // Message par défaut si aucun résultat
}
