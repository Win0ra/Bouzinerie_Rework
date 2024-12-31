document.getElementById('searchBar').addEventListener('input', async function() {
    const query = this.value.trim();
    if (!query) {
        document.getElementById('results').innerHTML = '';
        return;
    }

    try {
        const response = await fetch(`/ranking/search?q=${encodeURIComponent(query)}`);
        const data = await response.json();
        displayResults(data);
    } catch (error) {
        console.error('Erreur de recherche:', error);
    }
});

function displayResults(data) {
    const resultsDiv = document.getElementById('results');
    resultsDiv.innerHTML = data.length 
        ? data.map(player => `<p>${player.pseudo}</p>`).join('')
        : '<p>Aucun résultat trouvé.</p>';
}