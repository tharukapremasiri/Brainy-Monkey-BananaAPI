<?php
session_start();

// Fetch player scores from session
$sessionScores = isset($_SESSION['levels']) ? $_SESSION['levels'] : [];

$leaderboard = [];

if (!empty($sessionScores)) {
    foreach ($sessionScores as $level => $data) {
        // Store the highest score from the session for each level
        $leaderboard[$level] = $data['score'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <h2>🏆 Game Leaderboard 🏆</h2>
    
    <table border="1">
        <thead>
            <tr>
                <th>Level</th>
                <th>Highest Score</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display the highest score for each level
            if (!empty($leaderboard)) {
                foreach ($leaderboard as $level => $score) {
                    echo "<tr>
                            <td>Level $level</td>
                            <td>$score</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No scores available.</td></tr>";
            }
            ?>
        </tbody>
    </table>
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

    <a href="game.php" class="play-again-button">🔄 Play Again</a> <!-- Link to restart game -->
</body>
</html>
