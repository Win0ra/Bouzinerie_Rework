let currentQuestionIndex = 0;
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
    
    if (isCorrect) {
        score++;
    }
    
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
    
    scoreElement.textContent = `${score}/${questions.length}`;
    modal.style.display = 'block';
}

window.onload = startQuiz;
