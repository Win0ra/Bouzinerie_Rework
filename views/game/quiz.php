<?php require dirname(__DIR__).'/templates/header.php'; ?>

<div class="container">
    <div id="quiz-container">
        <!-- PAS TOUCHE  -->
    <input type="hidden" name="user_id" id="user-id" value="<?php echo $_SESSION["user_id"]; ?>"> 
    <input type="hidden" name="user-id" id="quiz-id" value="<?php echo $_GET["category"]; ?>">
    <!-- PAS TOUCHE JUST ADD STYLE -->
    <div id="timer">30</div>
    <!-- PAS TOUCHE JUST ADD STYLE -->
        <div id="question-container">
            <!-- PAS TOUCHE affichage questions -->
            <h3 id="question-text"></h3>
            <!-- PAS TOUCHE affiche réponses -->
            <div id="answers-container">
                <!-- Answers will be populated by JavaScript -->
            </div>
        </div>
        <div id="result-modal" class="modal">
            <div class="modal-content">
                <h2>Résultats</h2>
                <p>Score: <span id="score"></span></p>
                <button onclick="window.location.href='index.php?page=home'">Retour à l'accueil</button>
            </div>
        </div>
    </div>
</div>

<div class="statement">
        <h1>Questions</h1>
    </div>
    <div class="content">
        <div class="answers">

            <a class="answer">
                <p class="letter">A</p>
                <p class="item">Réponse 1</p>
            </a>
            <a class="answer">
                <p class="letter">B</p>
                <p class="item">Réponse 1</p>
            </a>
            <a class="answer">
                <p class="letter">C</p>
                <p class="item">Réponse 1</p>
            </a>
        </div>

    </div>

    <!-- LightBox -->
    <div class="lightbox">
        <div class="main">
            <div id="fermer">X</div>
        </div>
    </div>

    <div class="footer">
        <p>Question:</p>
        <p id="timer">0:30</p>
        <p id="score">Answers: 0/</p>
    </div>

    <!-- Formulaire pour relancer le quiz -->
    <form action="" method="get">
        <input type="hidden" name="quizz_id" value="">
        <input type="hidden" name="page" value="1">
        <input type="hidden" name="reset" value="true">
        <button type="submit">Relancer le quiz</button>
    </form>

<!-- NE PAS TOUCHER DE LA LIGNE 24 à 28 -->
<script>
    const questions = <?php echo json_encode($questions); ?>;
</script>
<script src="<?php  dirname(__DIR__)?>/public/js/quiz.js"></script>
