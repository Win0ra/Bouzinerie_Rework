// Variables globales
let timer;
let score = 0;
let correctAnswersCount = 0;
let canAnswer = true;

// Classe principale pour gérer le jeu de quiz
class QuizGame {
    constructor() {
        // Propriétés de la classe
        this.currentQuestionIndex = 0;  // Index de la question actuelle
        this.timer = null;             // Timer pour limiter le temps de réponse
        this.score = 0;                // Score total du joueur
        this.correctAnswersCount = 0;  // Nombre de bonnes réponses
        this.canAnswer = true;         // Indique si le joueur peut répondre
        this.totalQuestions = 0;       // Nombre total de questions
        this.timeLimit = 30;           // Temps limite pour répondre à chaque question
        this.startTime = null;         // Temps de début de la question

        // Eléments DOM
        this.questionContainer = document.getElementById('question-text');
        this.answersContainer = document.getElementById('answers-container');
        this.timerElement = document.getElementById('timer');
        this.progressElement = document.getElementById('progress');
        this.resultModal = document.getElementById('result-modal');
        this.scoreElement = document.getElementById('score');

        // Validation des éléments requis dans le DOM
        if (!this.validateElements()) {
            console.error('Eléments DOM manquants');
            return;
        }
    }

    // Vérifie que tous les éléments requis sont présents dans le DOM
    validateElements() {
        const requiredElements = [
            this.questionContainer,
            this.answersContainer,
            this.timerElement,
            this.resultModal,
            this.scoreElement
        ];
        return requiredElements.every(el => el !== null);
    }

    // Démarre le jeu de quiz
    start() {
        if (!this.validateQuestions()) {
            console.error('Pas de questions disponibles');
            return;
        }

        this.totalQuestions = questions.length; // Détermine le nombre total de questions
        this.showQuestion(questions[this.currentQuestionIndex]); // Affiche la première question
        this.startTimer(); // Démarre le timer
        this.updateProgress(); // Met à jour la progression
    }

    // Vérifie que les questions sont valides et non vides
    validateQuestions() {
        return Array.isArray(questions) && questions.length > 0;
    }

    // Affiche une question et ses réponses
    showQuestion(question) {
        if (!question || !question.answers) {
            console.error('Format de question invalide');
            return;
        }

        this.startTime = Date.now(); // Enregistre le temps de début
        this.questionContainer.textContent = question.question; // Affiche la question
        this.answersContainer.innerHTML = ''; // Vide le container des réponses

        try {
            const answers = JSON.parse(question.answers); // Analyse les réponses au format JSON
            answers.forEach((answer, index) => {
                const button = document.createElement('a'); // Crée un bouton pour chaque réponse
                button.className = 'answer ' + (String.fromCharCode(65 + index)).toLowerCase();
                button.dataset.index = index;

                const letter = document.createElement('p'); // Lettre associée (A, B, C, etc.)
                letter.className = 'letter ' + (String.fromCharCode(65 + index)).toLowerCase();
                letter.textContent = String.fromCharCode(65 + index);

                const item = document.createElement('p'); // Texte de la réponse
                item.className = 'item';
                item.textContent = answer;

                // Ajoute la lettre et le texte au bouton
                button.appendChild(letter);
                button.appendChild(item);

                // Configure l'événement onclick pour vérifier la réponse
                button.onclick = () => this.checkAnswer(index === question.correct_answer, question.correct_answer);

                // Ajoute le bouton au container des réponses
                this.answersContainer.appendChild(button);
            });
        } catch (error) {
            console.error('Erreur dans l\'analyse des réponses:', error);
            return;
        }

        this.canAnswer = true; // Permet de répondre
    }

    // Démarre le timer pour la question
    startTimer() {
        let timeLeft = this.timeLimit;
        this.timerElement.textContent = timeLeft;
        $('#current-question').text(this.currentQuestionIndex + 1)
        $('#total-question').text(this.totalQuestions)
        this.timer = setInterval(() => {
            timeLeft--;
            this.timerElement.textContent = timeLeft;

            if (timeLeft <= 0) {
                this.stopTimer(); // Arrête le timer si le temps est écoulé
                this.nextQuestion(); // Passe à la question suivante
            }
        }, 1000); // Intervalle de 1 seconde
    }

    // Arrête le timer
    stopTimer() {
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = null;
        }
    }

    // Vérifie la réponse donnée par le joueur
    checkAnswer(isCorrect, correctAnswerIndex) {
        if (!this.canAnswer) return; // Si déjà répondu, on ne fait rien

        this.stopTimer(); // Arrête le timer
        this.canAnswer = false;

        const responseTime = 30 - parseInt(this.timerElement.textContent); // Temps pris pour répondre
        const questionScore = this.calculateTimeScore(responseTime, isCorrect); // Calcule le score
        this.score += questionScore; // Ajoute le score à la note totale

        // Marque la bonne réponse et désactive les autres
        const answers = this.answersContainer.querySelectorAll('.answer');
        answers.forEach(answer => {
            const index = parseInt(answer.dataset.index);
            if (index === correctAnswerIndex) {
                answer.classList.add('correct-answer');
            } else {
                answer.classList.add('disabled-answer');
            }
        });

        if (isCorrect) {
            this.correctAnswersCount++; // Augmente le nombre de bonnes réponses si correct
        }

        // Passe à la question suivante après 2 secondes
        setTimeout(() => {
            answers.forEach(answer => {
                answer.classList.remove('correct-answer', 'disabled-answer');
            });
            this.nextQuestion();
        }, 2000);
    }

    // Passe à la question suivante ou affiche les résultats si c'est la fin
    nextQuestion() {
        this.currentQuestionIndex++;

        if (this.currentQuestionIndex >= this.totalQuestions) {
            this.showResults(); // Affiche les résultats si toutes les questions sont terminées
        } else {
            this.showQuestion(questions[this.currentQuestionIndex]); // Affiche la question suivante
            this.startTimer(); // Redémarre le timer
            this.updateProgress(); // Met à jour la progression
            console.log(`Question ${this.currentQuestionIndex + 1} of ${this.totalQuestions}`); // Log the current question
        }
    }

    // Met à jour l'affichage de la progression
    updateProgress() {
        if (this.progressElement) {
            this.progressElement.textContent = `Question ${this.currentQuestionIndex + 1} of ${this.totalQuestions}`;
        }
    }

    // Affiche les résultats finaux
    showResults() {
        const totalScore = this.score;
        console.log('Showing results:', totalScore);
        let user_id = $('#user-id').val(); // ID de l'utilisateur
        let quiz_id = $('#quiz-id').val(); // ID du quiz
        saveScore(user_id, totalScore, quiz_id, this.correctAnswersCount); // Sauvegarde le score
        this.scoreElement.innerHTML = `Total score: ${totalScore}`; // Affiche le score final
        this.resultModal.style.display = 'block'; // Affiche la modal des résultats
    }

    // Calcule le score en fonction du temps de réponse
    calculateTimeScore(responseTime, isCorrect) {
        const maxScore = 30; // Score maximum
        if (!isCorrect) return 0; // Pas de points pour une réponse fausse
        const score = Math.max(0, maxScore - (responseTime * 1)); // Déduit des points en fonction du temps écoulé
        return score;
    }
}

// Fonction pour sauvegarder le score via une requête HTTP POST
function saveScore(userId, score, quizId, totalCorrectQuestions) {
    fetch('index.php?page=saveScore', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ userId, score, quizId, totalCorrectQuestions }),
    })
    .then(response => response.json())
    .then(data => {
        // Affiche une boîte de dialogue avec les résultats
        const dialog = document.createElement('div');
        dialog.style.position = 'fixed';
        dialog.style.top = '50%';
        dialog.style.left = '50%';
        dialog.style.transform = 'translate(-50%, -50%)';
        dialog.style.backgroundColor = 'white';
        dialog.style.border = '1px solid #ccc';
        dialog.style.padding = '20px';
        dialog.style.zIndex = '1000';
        dialog.style.textAlign = 'center';
        dialog.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
        dialog.innerHTML = `
            <p>Votre score est de : ${score} points !!</p>
            <p>${data.message}</p>
            <button id="retakeQuiz" style="margin: 10px; padding: 10px;">Recommencer le quiz</button>
            <button id="backToGameList" style="margin: 10px; padding: 10px;">Retour aux quiz</button>
        `;

        // Ajoute la boîte de dialogue 
        document.body.appendChild(dialog);

        // Configure les actions des boutons
        document.getElementById('retakeQuiz').onclick = () => {
            location.reload(); // Recharge la page pour recommencer
        };
        document.getElementById('backToGameList').onclick = () => {
            window.location.href = 'index.php?page=home'; // Redirige vers la page d'accueil
        };
    })
    .catch((error) => {
        console.error('Error saving score:', error); // Log les erreurs en cas de problème
    });
}

// Démarre le quiz à l'ouverture de la page
window.onload = () => {
    const quiz = new QuizGame(); // Crée une instance du quiz
    quiz.start(); // Lance le quiz
    
};
