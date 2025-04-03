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
// Handle Answer Submission
function checkAnswer($userAnswer, $correctAnswer) {
    $level = $_SESSION['game_level'];
    $scorePerQuestion = 10 * $level;
    $response = [];

    // Timeout case
    if ($_POST['submitType'] === "timeout") {
        $_SESSION['levels'][$level]['lives']--;
        if ($_SESSION['levels'][$level]['lives'] == 0) {
            $response['status'] = "game_over";
            $response['message'] = "Time's up! Game Over!";
        } else {
            $_SESSION['current_question']++;
            $response['status'] = "life_lost";
            $response['message'] = "Time's up! You lost a life!";
        }
    } 
    // Correct Answer case
    elseif ($userAnswer == $correctAnswer) {
        $_SESSION['current_question']++;
        $_SESSION['levels'][$level]['score'] += $scorePerQuestion;

        // Check if all questions for the current level are completed
        if ($_SESSION['current_question'] > getQuestionsPerLevel($level)) {
            // Mark the level as completed
            $_SESSION['levels'][$level]['completed'] = true;

            // Check if the player has completed the current level
            $_SESSION['game_level']++; // Proceed to the next level
            initializeGameSession();
            $_SESSION['current_question'] = 1; // Reset the current question for the next level
            $response['status'] = "level_complete";
            $response['message'] = "Level $level complete! 🎉 Moving to Level " . $_SESSION['game_level'];
        } else {
            $response['status'] = "correct";
            $response['message'] = "Correct! 🎉 Next Question!";
        }
    } 
    // Incorrect Answer case
    else {
        $_SESSION['levels'][$level]['attempts']--;
        if ($_SESSION['levels'][$level]['attempts'] == 0) {
            $_SESSION['levels'][$level]['lives']--;
            $_SESSION['levels'][$level]['attempts'] = 3;

            if ($_SESSION['levels'][$level]['lives'] == 0) {
                $response['status'] = "game_over";
                $response['message'] = "Game Over!";
            } else {
                $response['status'] = "life_lost";
                $response['message'] = "Incorrect! You lost a life.";
            }
        } else {
            $response['status'] = "incorrect";
            $response['message'] = "Incorrect! Attempts left: " . $_SESSION['levels'][$level]['attempts'];
        }
    }

    // Return the updated status, score, lives, and attempts
    $response['score'] = $_SESSION['levels'][$level]['score'];
    $response['lives'] = $_SESSION['levels'][$level]['lives'];
    $response['attempts'] = $_SESSION['levels'][$level]['attempts'];
    $response['newQuestion'] = true;

    // Send the response as JSON
    echo json_encode($response);
    exit();
}


?>
