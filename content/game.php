<?php
include '../functions/api_function.php';
include '../functions/game_function.php';

$playerID = $_SESSION['playerID'] ?? null; // Get Player ID (if logged in)
$level = getPlayerLevel($playerID); // Get level from DB or session
initializeGameSession(); // Initialize lives & attempts

$questionData = getGameQuestion(); // Get new question
$questionsPerLevel = getQuestionsPerLevel($level); // Get question count per level
$attemptsRemaining = $_SESSION['attempts'] ?? 3; // Default attempts
$scores = $_SESSION['score'] ?? 0; // Default score
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brainy Monkey</title>
    <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    .game-container{
        background-color: green !important;

    }

  </style>
</head>
<body class="game-container" id="game-container">
    <div class="container">
        <div class="auth-buttons">
            <a href="login.html" id="login-button" class="btn">Login</a>
            <button id="logout-button" class="btn hidden" onclick="signOut()">Logout</button>
            <a href="profile.html"><img src="../assets/img/monkey-face.png" alt="Profile" class="profile-icon"></a>
        </div>

        <div class="game-body">
            <!-- Left Column -->
            <div class="left-column">
                <h2>Level <?php echo $level; ?> | Question <?php echo $_SESSION['current_question'] ?? 1; ?></h2>
                <?php if (!isset($questionData['error'])): ?>
                    <div class="image-div">
                        <img src="<?php echo $questionData['image_url']; ?>" alt="Question Image" class="question-image">
                    </div>
                    <div class="answer-div">
                        <input type="number" id="answerInput" placeholder="Enter your answer" class="answer-field">
                        <button id="submitAnswer">Submit</button>
                    </div>
                    <input type="hidden" id="correctAnswer" value="<?php echo $questionData['correct_answer']; ?>">
                <?php else: ?>
                    <p class="error-message">Error: <?php echo $questionData['error']; ?></p>
                <?php endif; ?>
            </div>

            <!-- Right Column -->
            <div class="right-column">
                <h3>Lives</h3>
                <div class="lives-container">
                    <?php for ($i = 0; $i < $_SESSION['lives']; $i++): ?>
                        <img src="../assets/img/monkey-face.png" class="life-icon">
                    <?php endfor; ?>
                </div>
                <h3>Attempts Remaining</h3>
                <p><?php echo $attemptsRemaining; ?></p>
                <h3>Score</h3>
                <p><?php echo $scores; ?></p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("submitAnswer").addEventListener("click", function () {
            let userAnswer = document.getElementById("answerInput").value;
            let correctAnswer = document.getElementById("correctAnswer").value;

            if (userAnswer.trim() === "") {
                alert("Please enter an answer.");
                return;
            }

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "check_answer.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let response = xhr.responseText.trim();
                    alert(response);
                    if (response.includes("Game Over")) {
                        window.location.href = "gameOver.php";
                    } else {
                        window.location.reload();
                    }
                }
            };
            xhr.send("userAnswer=" + userAnswer + "&correctAnswer=" + correctAnswer);
        });
    </script>
</body>
</html>
