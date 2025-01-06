function searchQuiz() {
    try {
        let searchTerm = document.getElementById('searchBar').value.toLowerCase();
        let cards = document.getElementsByClassName('card');
        let resultsDiv = document.getElementById('results');

        Array.from(cards).forEach(function(card) {
            let name = card.getAttribute('data-name').toLowerCase();
            
            if (name.includes(searchTerm)) {
                card.style.display = ''; // Affiche la carte
            } else {
                card.style.display = 'none'; // Cache la carte
            }
        });
    } catch (error) {
        let resultsDiv = document.getElementById('results');
        resultsDiv.innerHTML = '<p>Erreur lors de la recherche. Veuillez réessayer plus tard.</p>';
        console.error(error);
    }
}