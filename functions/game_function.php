<?php
session_start();
include ('../includes/config.php'); // Include DB connection

// Get Player Level
function getPlayerLevel($playerID = null) {
    if ($playerID) {
        global $conn;
        $query = "SELECT game_level FROM level WHERE playerID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $playerID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row['game_level'];
        }
    }
    return $_SESSION['game_level'] ?? 1; // Default Level 1 for guests
}

// Set Player Level in Session (For Guests)
function setGuestLevel($level) {
    $_SESSION['game_level'] = $level;
}

// Get Number of Questions Per Level
function getQuestionsPerLevel($level) {
    return 5 + ($level - 1); // Level 1 → 5, Level 2 → 6, Level 3 → 7, etc.
}

// Initialize Attempts & Lives
function initializeGameSession() {
    if (!isset($_SESSION['attempts'])) {
        $_SESSION['attempts'] = 5; // 5 attempts per question
    }
    if (!isset($_SESSION['lives'])) {
        $_SESSION['lives'] = 5; // 5 lives per level
    }
}

// Handle Answer Submission
function checkAnswer($userAnswer, $correctAnswer) {
    if ($userAnswer == $correctAnswer) {
        $_SESSION['current_question']++; // Move to next question
        $_SESSION['attempts'] = 5; // Reset attempts
        return "Correct! 🎉 Next Question!";
    } else {
        $_SESSION['attempts']--;

        if ($_SESSION['attempts'] == 0) {
            if ($_SESSION['lives'] > 0) {
                $_SESSION['lives']--; // Use a life
                $_SESSION['attempts'] = 5; // Reset attempts
                return "Incorrect! You lost a life. Try again!";
            } else {
                header("Location: gameOver.php"); // Redirect to Game Over
                exit();
            }
        }
        return "Incorrect! Attempts left: " . $_SESSION['attempts'];
    }
}
?>
