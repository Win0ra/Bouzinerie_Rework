let timer;
let score = 0;
let canAnswer = true;

function startQuiz() {
    showQuestion(questions[currentQuestionIndex]);
    startTimer();
}

function showQuestion(question) {
    const questionContainer = document.getElementById('question-text');
    const answersContainer = document.getElementById('answers-container');
    
    questionContainer.textContent = question.question;
    answersContainer.innerHTML = '';
    console.log(question.answers);
    const answers = JSON.parse(question.answers);
    answers.forEach((answer, index) => {
        const button = document.createElement('button');
        button.className = 'answer-btn';
        button.textContent = answer;
        button.onclick = () => checkAnswer(index === question.correct_answer);
        answersContainer.appendChild(button);
    });
    
    canAnswer = true;
}

function startTimer() {
    let timeLeft = 30;
    const timerElement = document.getElementById('timer');
    
    timer = setInterval(() => {
        timeLeft--;
        timerElement.textContent = timeLeft;
        
        if (timeLeft <= 0) {
            clearInterval(timer);
            nextQuestion();
        }
    }, 1000);
}

function checkAnswer(isCorrect) {
    if (!canAnswer) return;
    
    clearInterval(timer);
    canAnswer = false;
    
    const responseTime = 30 - parseInt(document.getElementById('timer').textContent); // Calculate time taken
    const questionScore = calculateTimeScore(responseTime, isCorrect);
    score += questionScore;
    
    setTimeout(nextQuestion, 1000);
}

function nextQuestion() {
    currentQuestionIndex++;
    
    if (currentQuestionIndex >= questions.length) {
        showResults();
    } else {
        showQuestion(questions[currentQuestionIndex]);
        startTimer();
    }
}

function showResults() {
    const modal = document.getElementById('result-modal');
    const scoreElement = document.getElementById('score');
    
    scoreElement.textContent = `Total Score: ${score}`;
    modal.style.display = 'block';
}

window.onload = startQuiz;
class QuizGame {
    constructor() {
        this.currentQuestionIndex = 0;
        this.timer = null;
        this.score = 0;
        this.canAnswer = true;
        this.totalQuestions = 0;
        this.timeLimit = 30;
        this.startTime = null;
        
        // DOM Elements
        this.questionContainer = document.getElementById('question-text');
        this.answersContainer = document.getElementById('answers-container');
        this.timerElement = document.getElementById('timer');
        this.progressElement = document.getElementById('progress');
        this.resultModal = document.getElementById('result-modal');
        this.scoreElement = document.getElementById('score');
        
        // Validate required elements
        if (!this.validateElements()) {
            console.error('Required DOM elements not found');
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
            console.error('No questions available');
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
            console.error('Invalid question format');
            return;
        }

        this.startTime = Date.now();
        this.questionContainer.textContent = question.question;
        this.answersContainer.innerHTML = '';
        
        try {
            const answers = JSON.parse(question.answers);
            answers.forEach((answer, index) => {
                const button = document.createElement('button');
                button.className = 'answer-btn';
                button.textContent = answer;
                button.onclick = () => this.checkAnswer(index === question.correct_answer);
                this.answersContainer.appendChild(button);
            });
        } catch (error) {
            console.error('Error parsing answers:', error);
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

    checkAnswer(isCorrect) {
        if (!this.canAnswer) return;
        
        this.stopTimer();
        this.canAnswer = false;
        
        // Calculate response time
        const responseTime = 30 - parseInt(this.timerElement.textContent); // Calculate time taken
        
        // Visual feedback
        const buttons = this.answersContainer.querySelectorAll('.answer-btn');
        buttons.forEach(button => button.disabled = true);
        
        const questionScore = this.calculateTimeScore(responseTime, isCorrect);
        this.score += questionScore;
        
        if (isCorrect) {
            this.answersContainer.classList.add('correct');
        } else {
            this.answersContainer.classList.add('incorrect');
        }
        
        setTimeout(() => {
            this.answersContainer.classList.remove('correct', 'incorrect');
            this.nextQuestion();
        }, 1000);
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
        this.scoreElement.innerHTML = `
            <div>Total Score: ${totalScore}</div>
        `;
        this.resultModal.style.display = 'block';
    }

    calculateTimeScore(responseTime, isCorrect) {
        const maxScore = 30;
        if (!isCorrect) return 0; // No points for incorrect answers
        const score = Math.max(0, maxScore - (responseTime * 1)); // 3 points deducted per second
        return score;
    }
}

// Initialize and start the quiz
window.onload = () => {
    const quiz = new QuizGame();
    quiz.start();
};
