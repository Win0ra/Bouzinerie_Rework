
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil La Bouzinerie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/styles-body.css" type="text/css" media="all">
    <script src="https://kit.fontawesome.com/e98829b701.js" crossorigin="anonymous"></script>
    <script src="public/js/search.js"></script>
</head>



    <div class="margin">
        <!-- PRESENTATION -->
        <div class="Presentation">
            <h2>La Bouzinerie, qu'est-ce que c'est ?</h2>
            <p>Tout simplement l'histoire de 3 jeunes développeurs en herbe adorant les quiz animés (voire même
                mouvementés) et qui se sont décidés à créer un site ludique et amusant.<br />
                L'idée du nom nous vient de "bouzin" signifiant "vacarme", ce qui nous semble essentiel lorsqu'on
                participe à des quiz !<br />
                Ici vous pourrez tester vos connaissances, et sûrement en apprendre de nouvelles !<br />
                Nous espérons que vous vous amuserez autant que nous ici !<br />
                Lequel d'entre-vous va devenir le meilleur Bouzin ? &#x1F600</p>
        </div>

        <!-- SEARCHBAR -->
        <div id="SearchBar">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="search" id="searchBar" placeholder="Rechercher un quiz..." oninput="searchQuiz()">
        </div>
        <div id="results"></div>

        <!-- QUIZ CARDS -->
        <h3>Nos quiz</h3>
        <div class="content">


            <?php foreach ($categories as $category): ?>
    <div class="card" data-name="<?php echo htmlspecialchars($category['name']); ?>">
        <div class="cards">
            <h5 class="card-title"><?php echo htmlspecialchars($category['name']); ?></h5>
            <img class="card-img-top" src="/views/uploads/categories/<?= basename($category['image']) ?>" 
                alt="Image de <?php echo htmlspecialchars($category['name']); ?>" width="50">
            <a href="index.php?page=quiz&category=<?php echo $category['id']; ?>" class="btn btn-primary">
                Jouer
            </a>
        </div>
    </div>
<?php endforeach; ?>

        </div>
    </div>





