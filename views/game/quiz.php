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
                    <!-- Réponses via JavaScript -->
                </div>
            </div>
            <div id="timer">30</div>
        </div>
        <div class="footer">
            <span id="current-question"></span>/<span id="total-question"></span>
        </div>

        <!-- Formulaire pour relancer le quiz -->
        <button onclick="window.location.href='index.php?page=home'">Retour à l'accueil</button>
    </div>
</div>

<?php
function utf8ize($data) {
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = utf8ize($value);
        }
    } elseif (is_string($data)) {
        return mb_convert_encoding($data, 'UTF-8', 'UTF-8');
    }
    return $data;
}

// Convert all data to UTF-8
$questions = utf8ize($questions);

// JSON encode with error handling
$jsonQuestions = json_encode($questions, JSON_UNESCAPED_UNICODE);

if (json_last_error() !== JSON_ERROR_NONE) {
    // Display error for debugging purposes
    echo "JSON Error: " . json_last_error_msg();
    die;
}
?>

<script>
    // Safely embed the questions array in JavaScript
    const questions = <?php echo $jsonQuestions; ?>;
</script>


<script src="<?php dirname(__DIR__) ?>/public/js/quiz.js"></script>