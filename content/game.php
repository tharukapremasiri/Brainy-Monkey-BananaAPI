<?php
include '../functions/api_function.php';
include '../functions/game_function.php';

$playerID = $_SESSION['playerID'] ?? null;
$level = getPlayerLevel($playerID);
initializeGameSession();

// Handle AJAX answer submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['userAnswer']) && isset($_POST['correctAnswer'])) {
    $userAnswer = $_POST['userAnswer'];
    $correctAnswer = $_POST['correctAnswer'];
    checkAnswer($userAnswer, $correctAnswer); // Call the function from game_function.php
}

// Game setup
$questionData = getGameQuestion();
$questionsPerLevel = getQuestionsPerLevel($level);
$attemptsRemaining = $_SESSION['levels'][$level]['attempts'];
$livesRemaining = $_SESSION['levels'][$level]['lives'];
$scores = $_SESSION['levels'][$level]['score'];
$_SESSION['time_remaining'] = 60; // Initialize timer for each question
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brainy Monkey</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .game-container { background-color: green !important; }
        .timer { font-size: 20px; font-weight: bold; color: red; }
        /* Reduce gap between h2 and p */
.title-div h2 {
    margin-bottom: 2px; /* Adjust margin to reduce gap */
    padding-bottom: 2px;
}

.title-div .timer {
    margin-top: 0; /* Remove margin above the timer */
    margin-bottom: 10px; /* Set margin below timer */
}

.image-div {
    margin-top: 2px; /* Adjust spacing above the image */
}

/* Optional: Set uniform padding/margins across the answer input and button */
.answer-div input,
.answer-div button {
    margin-top: 0px;
}

    </style>
</head>

<body class="game-container">
    <div class="container">
        <div class="auth-buttons">
            <a href="login.html" class="btn">Login</a>
            <button id="logout-button" class="btn hidden" onclick="signOut()">Logout</button>
            <a href="profile.html"><img src="../assets/img/monkey-face.png" alt="Profile" class="profile-icon"></a>
        </div>

        <div class="game-body">
            <!-- Left Column -->
            <div class="left-column">
                <div class="title-div">
                <h2 class="headers" style="font-size: 1.5rem;" style="margin-bottom: -5px;">Level <?php echo $level; ?> | Question <?php echo $_SESSION['current_question'] ?? 1; ?></h2>
                <p class="timer" id="timeRemaining" style="margin-bottom: -5px;">Time Remaining: 60s</p>
                </div>
                <?php if (!isset($questionData['error'])): ?>
                    <div class="image-div">
                        <img src="<?php echo $questionData['image_url']; ?>" alt="Question Image" class="question-image">
                    </div>
                    <div class="answer-div">
                        <input type="number" id="answerInput" placeholder="Enter your answer" class="answer-field">
                        <button id="submitAnswer">Submit</button>
                    </div>
                    <input type="text" id="correctAnswer" value="<?php echo $questionData['correct_answer']; ?>">
                <?php else: ?>
                    <p class="error-message">Error: <?php echo $questionData['error']; ?></p>
                <?php endif; ?>
            </div>

            <!-- Right Column (Game Summary) -->
            <div class="right-column">
                <h3>Game Summary</h3>
                <h3>Lives</h3>
                <div class="lives-container" id="livesContainer">
                    <?php for ($i = 0; $i < $livesRemaining; $i++): ?>
                        <img src="../assets/img/monkey-face.png" class="life-icon">
                    <?php endfor; ?>
                </div>

                <h3>Attempts Remaining</h3>
                <p id="attempts"><?php echo $attemptsRemaining; ?></p>

                <h3>Score</h3>
                <p id="score"><?php echo $scores; ?></p>
            </div>
        </div>
         <!-- Bottom Left: Exit Button -->
    <div class="exit-container">
        <!-- <button id="exit-game" onclick="exitGame()" >
            Exit -->
            <!-- <img src="../assets/img/exit.png" alt="Exit" class="exit-icon" /> -->
            <!-- Optionally use a Font Awesome icon, uncomment below if using Font Awesome -->
            <!-- <i class="fa fa-sign-out-alt exit-icon"></i> -->
        <!-- </button> -->
        <a href="../index.php">
        <img src="../assets/img/left.png" alt="Back" />
      </a>
    </div>


    <!-- Bottom Right: Speaker & Settings -->
    <div class="asset-container">
        <a href="#">
            <img src="../assets/img/speker.png" alt="Speaker" />
        </a>
        <a href="#">
            <img src="../assets/img/settings.png" alt="Settings" />
        </a>
    </div>
    </div>

    <script>
        let timer = 60;
        let timerInterval = setInterval(() => {
            document.getElementById("timeRemaining").textContent = "Time Remaining: " + timer + "s";
            if (timer === 0) {
                clearInterval(timerInterval);
                submitAnswer("timeout"); // Auto-submit when time is up
            }
            timer--;
        }, 1000);

        document.getElementById("submitAnswer").addEventListener("click", function() {
            submitAnswer("user");
        });

        function submitAnswer(submitType) {
            let userAnswer = document.getElementById("answerInput").value;
            let correctAnswer = document.getElementById("correctAnswer").value;

            fetch("game.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "userAnswer=" + encodeURIComponent(userAnswer) + "&correctAnswer=" + encodeURIComponent(correctAnswer) + "&submitType=" + submitType,
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.status === "game_over") {
                    window.location.href = "gameOver.php";
                } else {
                    updateGameSummary(data);
                }
            })
            .catch(error => console.error("Error:", error));
        }

        function updateGameSummary(data) {
            document.getElementById("score").textContent = data.score;
            document.getElementById("attempts").textContent = data.attempts;
            document.getElementById("livesContainer").innerHTML = "";
            for (let i = 0; i < data.lives; i++) {
                document.getElementById("livesContainer").innerHTML += '<img src="../assets/img/monkey-face.png" class="life-icon">';
            }
            if (data.newQuestion) {
                setTimeout(() => location.reload(), 1000);
            }
        }
    </script>
    <script src="exit.js"></script>

</body>
</html>
