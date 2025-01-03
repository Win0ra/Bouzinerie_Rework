<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil La Bouzinerie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/bouzinerie_rework/public/css/styles-body.css" type="text/css" media="all">
    <script src="https://kit.fontawesome.com/e98829b701.js" crossorigin="anonymous"></script>
</head>

<body>
<body>
    <div class="margin">
        <!-- PRESENTATION -->
        <div class="Presentation">
            <h2>La Bouzinerie, qu'est-ce que c'est ?</h2>
            <p>Tout simplement l'histoire de 3 jeunes développeurs en herbe adorant les quiz animés (voire même
                mouvementés) et qui se sont décidés à créer un site ludique et amusant.<br />
                L'idée du nom nous vient de "bouzin" signifiant "vacarme", ce qui nous semble essentiel lorsqu'on
                participe à des quiz entre ami.e.s !<br />
                Ici vous pourrez tester vos connaissances, et sûrement en apprendre de nouvelles !<br />
                Nous espérons que vous vous amuserez autant que nous ici !<br />
                Lequel d'entre-vous va devenir le meilleur Bouzin ? &#x1F600</p>
        </div>

        <!-- SEARCHBAR -->
        <div id="SearchBar">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="searchBar" placeholder="Rechercher un quiz..." oninput="searchQuiz()">
        </div>
        <div id="results"></div>

        <script type="text/javascript">
            async function searchQuiz() {
                const query = document.getElementById('searchBar').value.trim();
                const resultsDiv = document.getElementById('results');

                if (query.length === 0) {
                    resultsDiv.innerHTML = ''; // Vider les résultats si barre de recherche vide
                    return;
                }

                try {
                    const response = await fetch(`../back/src/insert/search.php?q=${encodeURIComponent(query)}`);
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

        <!-- QUIZ CARDS -->
        <h3>Nos quiz</h3>
        <div class="content">
            <?php
            // Liste des quiz avec les noms de leurs images correspondantes
            $quiz = [
                'League of Legends' => 'lol.jpg',
                'World of Warcraft' => 'wow.jpg',
                'Dofus' => 'dofus.jpg',
                'Films' => 'movies.jpg',
                'Sciences' => 'science.jpg',
                'Littérature' => 'litterature.jpg',
                'Cuisine' => 'food.jpg',
                'Histoire' => 'history.jpg',
                'Géographie' => 'geography.jpg'
            ];

            // Parcours des quiz pour générer les cartes dynamiquement
            foreach ($quiz as $quizName => $image) {
                // Définir le chemin de base pour les images
                $imagePath = '/bouzinerie_rework/public/img/' . $image;

                // Génération de la carte
                echo '
                <div class="card">
                    <div class="cards">
                        <h5 class="card-title">' . htmlspecialchars($quizName) . '</h5>
                        <img src="' . $imagePath . '" alt="Image de ' . htmlspecialchars($quizName) . '" class="card-img-top">
                        <a href="#" class="btn btn-primary">Jouer</a>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>
</body>

</html>


