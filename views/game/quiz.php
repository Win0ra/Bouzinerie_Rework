<?php require dirname(__DIR__) . '/templates/header.php'; ?>

<div class="container">
    <div id="quiz-container">
        <input type="hidden" name="user_id" id="user-id" value="<?php echo $_SESSION["user_id"]; ?>">
        <input type="hidden" name="user-id" id="quiz-id" value="<?php echo $_GET["category"]; ?>">

        <div id="question-container" class="statement">
            <h3 id="question-text"></h3>
        </div>
        <div class="content">
            <div class="answers">
                <div id="answers-container">
                    <!-- Answers will be populated by JavaScript -->
                </div>

            </div>
            <div id="timer">30</div>

        </div>
        <div class="footer">
            <span id="score"></span>
            <!-- <div id="timer">30</div> -->
        </div>

        <!-- Formulaire pour relancer le quiz -->
        <button onclick="window.location.href='index.php?page=home'">Retour à l'accueil</button>

    </div>
</div>

<!-- NE PAS TOUCHER DE LA LIGNE 24 à 28 -->
<script>
    const questions = <?php echo json_encode($questions); ?>;
</script>
<script src="<?php dirname(__DIR__) ?>/public/js/quiz.js"></script>