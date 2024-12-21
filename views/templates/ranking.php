<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil La Bouzinerie</title>
    <link rel="stylesheet" href="/bouzinerie_rework/public/css/styles-ranking.css" type="text/css" media="all">
    <script src="https://kit.fontawesome.com/e98829b701.js" crossorigin="anonymous"></script>
</head>

<body>

    <div class="margin">
        <h1>Classement Général</h1>
        <!-- BLOCKS DEBUT -->
        <div class="Blocks">
            <div class="Second">
                <i class="fa-sharp fa-solid fa-trophy" id="second"></i>
                <div class="SecondBlock">
                    <p class="p-podium">Anne-Boolé</p> <!-- Nom du 2eme -->
                </div>
            </div>
            <div class="First">
                <i class="fa-sharp fa-solid fa-trophy" id="first"></i>
                <div class="FirstBlock">
                    <p class="p-podium">Bouzin69</p> <!-- Nom du 1er -->
                </div>
            </div>
            <div class="Third">
                <i class="fa-sharp fa-solid fa-trophy" id="third"></i>
                <div class="ThirdBlock">
                    <p class="p-podium">Raoul</p> <!-- Nom du 3eme -->
                </div>
            </div>
        </div>
        <!-- BLOCKS FIN -->

        <!-- SEARCHBAR DEBUT -->
                <!-- SEARCHBAR -->
                <div id="SearchBar">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="searchBar" placeholder="Rechercher un joueur..." oninput="searchPlayer()">
        </div>
        <div id="results"></div>

        <script type="text/javascript">
            async function searchPlayer() {
                const query = document.getElementById('searchBar').value.trim();
                const resultsDiv = document.getElementById('results');

                if (query.length === 0) {
                    resultsDiv.innerHTML = ''; // Vider les résultats si barre de recherche vide
                    return;
                }

                try {
                    const response = await fetch(`../back/src/insert/search.php?q=${encodeURIComponent(query)}`); // modifier constante pour chercher les joueurs
                    const data = await response.json();
                    if (data.length > 0) {
                        resultsDiv.innerHTML = data.map(item => `<p>${item.title}</p>`).join('');
                    } else {
                        resultsDiv.innerHTML = '<p> Aucun résultat trouvé. </p>';
                    }
                } catch (error) {
                    resultsDiv.innerHTML = '<p> Erreur lors de la recherche. Veuillez réessayer plus tard. </p>';
                    console.error(error);
                }
            }
        </script>
        <!-- SEARCHBAR FIN -->
        <!-- RANKING DEBUT -->
        <div class="General-Ranking">
            <div class="Ranking-List">
                <h3 class="h3-position">Position</h3>
                <h3 class="h3-pseudo">Pseudo</h3>
                <h3 class="h3-score">Score</h3>
            </div>
            <ul class="List-group-horizontal">
                <li class="Position">1</li>
                <li class="Pseudo">Bouzineur-le-GOAT</li>
                <li class="Score">999 999 999 999</li>
            </ul>
            <ul class="List-group-horizontal">
                <li class="Position">1</li>
                <li class="Pseudo">Bouzineur-le-GOAT</li>
                <li class="Score">999 999 999 999</li>
            </ul>
            <ul class="List-group-horizontal">
                <li class="Position">1</li>
                <li class="Pseudo">Bouzineur-le-GOAT</li>
                <li class="Score">999 999 999 999</li>
            </ul>
            <ul class="List-group-horizontal">
                <li class="Position">1</li>
                <li class="Pseudo">Bouzineur-le-GOAT</li>
                <li class="Score">999 999 999 999</li>
            </ul>
            <ul class="List-group-horizontal">
                <li class="Position">1</li>
                <li class="Pseudo">Bouzineur-le-GOAT</li>
                <li class="Score">999 999 999 999</li>
            </ul>
            <ul class="List-group-horizontal">
                <li class="Position">1</li>
                <li class="Pseudo">Bouzineur-le-GOAT</li>
                <li class="Score">999 999 999 999</li>
            </ul>
            <ul class="List-group-horizontal">
                <li class="Position">1</li>
                <li class="Pseudo">Bouzineur-le-GOAT</li>
                <li class="Score">999 999 999 999</li>
            </ul>
            <ul class="List-group-horizontal">
                <li class="Position">1</li>
                <li class="Pseudo">Bouzineur-le-GOAT</li>
                <li class="Score">999 999 999 999</li>
            </ul>
            <ul class="List-group-horizontal">
                <li class="Position">1</li>
                <li class="Pseudo">Bouzineur-le-GOAT</li>
                <li class="Score">999 999 999 999</li>
            </ul>
            <ul class="List-group-horizontal">
                <li class="Position">1</li>
                <li class="Pseudo">Bouzineur-le-GOAT</li>
                <li class="Score">999 999 999 999</li>
            </ul>
            <ul class="List-group-horizontal">
                <li class="Position">1</li>
                <li class="Pseudo">Bouzineur-le-GOAT</li>
                <li class="Score">999 999 999 999</li>
            </ul>
            <ul class="List-group-horizontal">
                <li class="Position">1</li>
                <li class="Pseudo">Bouzineur-le-GOAT</li>
                <li class="Score">999 999 999 999</li>
            </ul>
            <ul class="List-group-horizontal">
                <li class="Position">1</li>
                <li class="Pseudo">Bouzineur-le-GOAT</li>
                <li class="Score">999 999 999 999</li>
            </ul>
            <ul class="List-group-horizontal">
                <li class="Position">1</li>
                <li class="Pseudo">Bouzineur-le-GOAT</li>
                <li class="Score">999 999 999 999</li>
            </ul>
            <ul class="List-group-horizontal">
                <li class="Position">1</li>
                <li class="Pseudo">Bouzineur-le-GOAT</li>
                <li class="Score">999 999 999 999</li>
            </ul>
            <ul class="List-group-horizontal">
                <li class="Position">1</li>
                <li class="Pseudo">Bouzineur-le-GOAT</li>
                <li class="Score">999 999 999 999</li>
            </ul>
            <ul class="List-group-horizontal">
                <li class="Position">1</li>
                <li class="Pseudo">Bouzineur-le-GOAT</li>
                <li class="Score">999 999 999 999</li>
            </ul>
            <ul class="List-group-horizontal">
                <li class="Position">1</li>
                <li class="Pseudo">Bouzineur-le-GOAT</li>
                <li class="Score">999 999 999 999</li>
            </ul>
            <ul class="List-group-horizontal">
                <li class="Position">1</li>
                <li class="Pseudo">Bouzineur-le-GOAT</li>
                <li class="Score">999 999 999 999</li>
            </ul>
            <ul class="List-group-horizontal">
                <li class="Position">1</li>
                <li class="Pseudo">Bouzineur-le-GOAT</li>
                <li class="Score">999 999 999 999</li>
            </ul>
        </div>
    </div>

    <!-- RANKING FIN -->
    <?php require dirname(__DIR__). '/templates/footer.php'; ?>