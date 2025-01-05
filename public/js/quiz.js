let timer;
let score = 0;
let correctAnswersCount = 0;
let canAnswer = true;

class QuizGame {
    constructor() {
        this.currentQuestionIndex = 0;
        this.timer = null;
        this.score = 0;
        this.correctAnswersCount = 0;
        this.canAnswer = true;
        this.totalQuestions = 0;
        this.timeLimit = 30;
        this.startTime = null;

        // Eléments du DOM
        this.questionContainer = document.getElementById('question-text');
        this.answersContainer = document.getElementById('answers-container');
        this.timerElement = document.getElementById('timer');
        this.progressElement = document.getElementById('progress');
        this.resultModal = document.getElementById('result-modal');
        this.scoreElement = document.getElementById('score');

        // Validation des éléments requis
        if (!this.validateElements()) {
            console.error('Eléments DOM manquants');
            return;
        }
    }

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

    start() {
        if (!this.validateQuestions()) {
            console.error('Pas de questions disponibles');
            return;
        }

        this.totalQuestions = questions.length;
        this.showQuestion(questions[this.currentQuestionIndex]);
        this.startTimer();
        this.updateProgress();
    }

    validateQuestions() {
        return Array.isArray(questions) && questions.length > 0;
    }

    showQuestion(question) {
        if (!question || !question.answers) {
            console.error('Format de question invalide');
            return;
        }

        this.startTime = Date.now();
        this.questionContainer.textContent = question.question;
        this.answersContainer.innerHTML = '';

        try {
            const answers = JSON.parse(question.answers);
            answers.forEach((answer, index) => {
                const button = document.createElement('a');
                button.className = 'answer ' + (String.fromCharCode(65 + index)).toLowerCase();
                button.dataset.index = index;

                // Crée la lettre via <p>
                const letter = document.createElement('p');
                letter.className = 'letter ' +(String.fromCharCode(65 + index)).toLowerCase();
                letter.textContent = String.fromCharCode(65 + index); // Converti l'index en A, B, C, etc.

                // Crée <p>
                const item = document.createElement('p');
                item.className = 'item';
                item.textContent = answer;

                // Ajoute <p> à <a>
                button.appendChild(letter);
                button.appendChild(item);

                // Configure l'event onclick pour vérifier la réponse
                button.onclick = () => this.checkAnswer(index === question.correct_answer, question.correct_answer);

                // Ajoute l'élément <a> au container des réponses
                this.answersContainer.appendChild(button);
            });
        } catch (error) {
            console.error('Erreur dans l\'analyse des réponses:', error);
            return;
        }

        this.canAnswer = true;
    }

    startTimer() {
        let timeLeft = this.timeLimit;
        this.timerElement.textContent = timeLeft;

        this.timer = setInterval(() => {
            timeLeft--;
            this.timerElement.textContent = timeLeft;

            if (timeLeft <= 0) {
                this.stopTimer();
                this.nextQuestion();
            }
        }, 1000);
    }

    stopTimer() {
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = null;
        }
    }

    checkAnswer(isCorrect, correctAnswerIndex) {
        if (!this.canAnswer) return;

        this.stopTimer();
        this.canAnswer = false;

        const responseTime = 30 - parseInt(this.timerElement.textContent);
        const questionScore = this.calculateTimeScore(responseTime, isCorrect);
        this.score += questionScore;

        // Mettre en évidence la bonne réponse et désactiver les autres
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
            this.correctAnswersCount++;
        }

        // Attendre 2 secondes avant de passer à la question suivante
        setTimeout(() => {
            answers.forEach(answer => {
                answer.classList.remove('correct-answer', 'disabled-answer');
            });
            this.nextQuestion();
        }, 2000);
    }

    nextQuestion() {
        this.currentQuestionIndex++;

        if (this.currentQuestionIndex >= this.totalQuestions) {
            this.showResults();
        } else {
            this.showQuestion(questions[this.currentQuestionIndex]);
            this.startTimer();
            this.updateProgress();
        }
    }

    updateProgress() {
        if (this.progressElement) {
            this.progressElement.textContent = `Question ${this.currentQuestionIndex + 1} of ${this.totalQuestions}`;
        }
    }

    showResults() {
        const totalScore = this.score;
        console.log('Showing results:', totalScore);
        let user_id = $('#user-id').val();
        let quiz_id = $('#quiz-id').val();
        saveScore(user_id, totalScore, quiz_id, this.correctAnswersCount);
        this.scoreElement.innerHTML = `Total Score: ${totalScore}`;
        this.resultModal.style.display = 'block';
    }

    calculateTimeScore(responseTime, isCorrect) {
        const maxScore = 30;
        if (!isCorrect) return 0; // Pas de points pour une réponse fausse
        const score = Math.max(0, maxScore - (responseTime * 1)); // 1 point déduit par seconde écoulée
        return score;
    }
}

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
            <p>Votre score est de : ${score} points ! BRAVO !</p>
            <p>${data.message}</p>
            <button id="retakeQuiz" style="margin: 10px; padding: 10px;">Recommencer le quiz</button>
            <button id="backToGameList" style="margin: 10px; padding: 10px;">Retour aux quiz</button>
        `;

        // Ajoute la boite de dialogue à la page
        document.body.appendChild(dialog);

        // Event listeners pour les buttons
        document.getElementById('retakeQuiz').onclick = () => {
            location.reload(); // Reload de la page
        };
        document.getElementById('backToGameList').onclick = () => {
            window.location.href = 'index.php?page=home'; // Redirection vers la page d'accueil
        };
    })
    .catch((error) => {
        console.error('Error saving score:', error);
    });
}

window.onload = () => {
    const quiz = new QuizGame();
    quiz.start();
};
