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

// Handle AJAX answer submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['userAnswer']) && isset($_POST['correctAnswer'])) {
    $userAnswer = $_POST['userAnswer'];
    $correctAnswer = $_POST['correctAnswer'];

    checkAnswer($userAnswer, $correctAnswer); // Call the function from game_function.php
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brainy Monkey</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .game-container {
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
                    <input type="text" id="correctAnswer" value="<?php echo $questionData['correct_answer']; ?>">
                <?php else: ?>
                    <p class="error-message">Error: <?php echo $questionData['error']; ?></p>
                <?php endif; ?>
            </div>

            <!-- Right Column -->
            <div class="right-column">
                <h3>Lives</h3>
                <div class="lives-container">
                    <?php
                    // Ensure lives, attempts, and score are initialized
                    $lives = $_SESSION['levels'][$_SESSION['game_level']]['lives'] ?? 2; // Default 2 lives
                    $attempts = $_SESSION['levels'][$_SESSION['game_level']]['attempts'] ?? 3; // Default 3 attempts
                    $score = $_SESSION['levels'][$_SESSION['game_level']]['score'] ?? 0; // Default score 0

                    // Display lives as monkey images
                    for ($i = 0; $i < $lives; $i++): ?>
                        <img src="../assets/img/monkey-face.png" class="life-icon">
                    <?php endfor; ?>
                </div>

                <h3>Attempts Remaining</h3>
                <p><?php echo $attempts; ?></p>

                <h3>Score</h3>
                <p><?php echo $score; ?></p>
            </div>

        </div>
    </div>

    <script>
        document.getElementById("submitAnswer").addEventListener("click", function() {
            let userAnswer = document.getElementById("answerInput").value;
            let correctAnswer = document.getElementById("correctAnswer").value;

            fetch("game.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "userAnswer=" + encodeURIComponent(userAnswer) + "&correctAnswer=" + encodeURIComponent(correctAnswer),
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message); // Show message (incorrect, correct, or life lost)

                    if (data.status === "game_over") {
                        window.location.href = data.redirect; // Redirect to restart level
                    } else if (data.status === "level_complete") {
                        window.location.reload(); // Move to next level
                    } else if (data.status === "correct" || data.status === "life_lost") {
                        window.location.reload(); // Reload if correct or lost a life
                    }
                })
                .catch(error => console.error("Error:", error));
        });
    </script>

</body>
</html>