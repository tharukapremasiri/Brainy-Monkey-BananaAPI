<?php
session_start(); // Start the session
include('../includes/config.php'); // Include DB connection

// Check if the guest user has already completed the challenge today
$currentDate = date('Y-m-d'); // Get today's date

// Initialize challenge status and date from session if available
$challengeCompleted = $_SESSION['challenge_completed'] ?? false;
$completedDate = $_SESSION['challenge_date'] ?? '';

// If the date stored in the session is not today's date, reset the challenge status
if ($completedDate !== $currentDate) {
    $_SESSION['challenge_completed'] = false; // Reset challenge status for a new day
}

// Handle form submission when the guest starts the challenge
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$challengeCompleted) {
    // Logic for starting the daily challenge (e.g., generating the game or questions)
    // For simplicity, we'll just mark the challenge as completed.
    $_SESSION['challenge_completed'] = true; // Mark the challenge as completed for today
    $_SESSION['challenge_date'] = $currentDate; // Store today's date when the challenge was completed

    echo "<p>🎉 Challenge completed! Good job! 🎉</p>";
    // Optionally, you can redirect to a game page or show a challenge success message
    // header('Location: game.php'); // Redirect to the game page (optional)
    // exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Challenge</title>
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <h2 style="color: black;">🏆 Daily Challenge 🏆</h2>

    <?php if ($challengeCompleted): ?>
        <!-- Show message if the user has already completed the challenge today -->
        <p>You have already completed today's challenge! Come back tomorrow for a new challenge.</p>
    <?php else: ?>
        <!-- Show the option to start the challenge if not completed yet -->
        <p>Ready for today's challenge? Complete it to earn rewards!</p>
        <form action="dailychallenge.php" method="post">
            <button type="submit">Start Daily Challenge</button>
        </form>
    <?php endif; ?>

    <!-- Option to go back to the game -->
    <a href="game.php">Back to Game</a>

</body>
</html>
