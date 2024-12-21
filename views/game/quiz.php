<?php require dirname(__DIR__).'/templates/header.php'; ?>

<div class="container">
    <div id="quiz-container">
        <div id="timer">30</div>
        <div id="question-container">
            <h3 id="question-text"></h3>
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

<script>
    const questions = <?php echo json_encode($questions); ?>;
</script>
<script src="<?php  dirname(__DIR__)?>/public/js/quiz.js"></script>
