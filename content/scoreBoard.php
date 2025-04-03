<?php
session_start();
include('../includes/config.php'); // Include DB connection

// Get player ID if logged in (optional)
$playerID = $_SESSION['playerID'] ?? null;

// Fetch completed level scores from session
$completedLevels = $_SESSION['levels'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scoreboard</title>
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Link to your CSS file -->
</head>

<body>
    <h2 style="color: black;"><img src="../assets/img/banan-box.png" alt="Banana" style="height: 40px;"> Player Scoreboard <img src="../assets/img/star.png" alt="Banana" style="height: 40px;"></h2>

    <table>
        <thead>
            <tr>
                <th>Level</th>
                <th>Score</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($completedLevels)) {
                foreach ($completedLevels as $level => $data) {
                    $status = "In Progress";  // Default status
                    $statusMessage = "Keep Going!";  // Default message

                    if ($data['completed']) {
                        $status = "Completed";  // If level is marked as completed
                        $statusMessage = "🎉 Level Completed!";
                    } elseif ($data['lives'] == 0) {
                        $status = "Game Over";
                        $statusMessage = "💀 Game Over!";
                    } else {
                        $status = "In Progress";
                        $statusMessage = "⏳ Level in Progress";
                    }

                    // Show only levels where a score was earned or level is completed
                    if ($data['score'] > 0 || $data['completed'] === true) {
                        // Calculate the number of bananas based on the score
                        $bananas = floor($data['score'] / 10); // Each banana represents 10 points
                        $bananaIcons = str_repeat('<img src="../assets/img/banana.png" class="banana-icon" alt="Banana">', $bananas);

                        echo "<tr>
                                <td>Level $level</td>
                                <td>{$bananaIcons}</td>
                                <td class='status-message'>{$statusMessage}</td>
                              </tr>";
                    }
                }
            } else {
                echo "<tr><td colspan='3'>No levels completed yet.</td></tr>";
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
    <!-- Link to restart game -->

    <script src="../assets/js/exit.js"></script>
</body>

</html>