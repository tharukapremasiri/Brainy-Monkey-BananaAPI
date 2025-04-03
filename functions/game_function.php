<?php
session_start();
include ('../includes/config.php'); // Include DB connection

// Ensure game level is set in session
if (!isset($_SESSION['game_level'])) {
    $_SESSION['game_level'] = 1; // Default level 1 if not set
}

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

// Initialize Attempts & Lives for current level
function initializeGameSession() {
    $level = $_SESSION['game_level'];

    // Ensure 'levels' array exists
    if (!isset($_SESSION['levels'])) {
        $_SESSION['levels'] = [];
    }

    // Ensure current level is initialized
    if (!isset($_SESSION['levels'][$level])) {
        $_SESSION['levels'][$level] = [
            'attempts' => 3,  // Default 3 attempts per question
            'lives' => 2,     // Default 2 lives per level
            'score' => 0,     // Initialize score
            'completed' => false // Level completion status
        ];
    }
}

// Handle Answer Submission
function checkAnswer($userAnswer, $correctAnswer) {
    $level = $_SESSION['game_level'];
    $response = [];

    // Check if the answer is empty
    if ($userAnswer === "") {
        $response['status'] = "error";
        $response['message'] = "Please enter an answer.";
    }
    // Check if the answer is correct
    elseif ($userAnswer == $correctAnswer) {
        $_SESSION['current_question']++; // Move to next question
        $_SESSION['levels'][$level]['attempts'] = 3; // Reset attempts for next question

        // Check if level is complete
        if ($_SESSION['current_question'] > getQuestionsPerLevel($level)) {
            $_SESSION['levels'][$level]['completed'] = true; // Mark level as completed
            $_SESSION['game_level']++; // Move to next level
            initializeGameSession(); // Reset attempts and lives for next level
            $_SESSION['current_question'] = 1; // Reset question count

            $response['status'] = "level_complete";
            $response['message'] = "Level $level complete! 🎉 Moving to Level " . $_SESSION['game_level'];
        } else {
            $response['status'] = "correct";
            $response['message'] = "Correct! 🎉 Next Question!";
        }
    } else {
        // Check if the game is over for this level
        if ($_SESSION['levels'][$level]['lives'] == 0) {
            $response['status'] = "game_over";
            $response['message'] = "Game Over! Restarting Level $level...";

            // Reset only current level data (not previous levels)
            $_SESSION['levels'][$level]['attempts'] = 3;
            $_SESSION['levels'][$level]['lives'] = 2;
            $_SESSION['current_question'] = 1; // Restart level

            $response['redirect'] = "gameOver.php";  // Indicate redirection to restart level
        } else {
            $_SESSION['levels'][$level]['attempts']--; // Decrease attempts

            if ($_SESSION['levels'][$level]['attempts'] == 0) {
                if ($_SESSION['levels'][$level]['lives'] > 0) {
                    $_SESSION['levels'][$level]['lives']--; // Use a life
                    $_SESSION['levels'][$level]['attempts'] = 3; // Reset attempts
                    $response['status'] = "life_lost";
                    $response['message'] = "Incorrect! You lost a life. Try again!";
                }
            } else {
                $response['status'] = "incorrect";
                $response['message'] = "Incorrect! Attempts left: " . $_SESSION['levels'][$level]['attempts'];
            }
        }
    }

    echo json_encode($response);
    exit();
}
?>
