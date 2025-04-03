<?php 
session_start(); 
// Check if the user is logged in
if (!isset($_SESSION['playerID'])) {
    header("Location: index.php"); // Redirect to index page if not logged in
    exit();
}

// Fetch player data from session
$playerID = $_SESSION['playerID'];
$playerName = $_SESSION['playerName'];
$sessionScores = isset($_SESSION['levels']) ? $_SESSION['levels'] : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <h2>Player Profile: <?php echo $playerName; ?></h2>

    <div class="profile-info">
        <div class="profile-img-container">
            <!-- Display profile image (make sure the path is correct) -->
            <img src="../assets/img/profile-<?php echo $playerID; ?>.png" alt="Profile Image" class="profile-img">
        </div>
        
        <h3>Game Status and Scores</h3>
        
        <table border="1">
            <thead>
                <tr>
                    <th>Level</th>
                    <th>Score</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display the highest score for each level from session data
                if (!empty($sessionScores)) {
                    foreach ($sessionScores as $level => $data) {
                        // Define status based on the session data
                        $status = "In Progress";  // Default status
                        if (isset($data['completed']) && $data['completed']) {
                            $status = "Completed";
                        } elseif ($data['lives'] == 0) {
                            $status = "Game Over";
                        }
                        echo "<tr>
                                <td>Level $level</td>
                                <td>{$data['score']}</td>
                                <td>{$status}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No game data available.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <a href="index.php">Back to Home</a>

</body>
</html>
