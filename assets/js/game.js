async function fetchQuestion() {
    const response = await fetch("https://your-api.com/getQuestion");
    const data = await response.json();
    return data;
}

async function startGame() {
    const questionData = await fetchQuestion();
    document.getElementById("question-image").src = questionData.question;
    window.correctAnswer = questionData.solution;
}

function checkAnswer(selectedAnswer) {
    if (selectedAnswer === window.correctAnswer) {
        alert("Correct! 🎉");
        startGame(); // Load next question
    } else {
        alert("Wrong answer! Try again.");
    }
}

startGame();
