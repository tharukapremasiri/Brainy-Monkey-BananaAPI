<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Brainy Monkey</title>
  <link rel="stylesheet" href="assets/css/style.css" />
  <script src="https://accounts.google.com/gsi/client" async defer></script>
</head>

<body>
  <div class="container">
    <!-- Auth Buttons at the Top Right -->
    <div class="auth-buttons">
      <a href="login.html" id="login-button" class="btn">Login</a>
      <button id="logout-button" class="btn hidden" onclick="signOut()">
        Logout
      </button>
      <!-- Profile Icon with Yellow Background -->
      <a href="content/profile.php">
        <img src="assets/img/monkey-face.png" alt="Profile" />
      </a>
    </div>

    <!-- Centered Title (No gap after login button) -->
    <h1 class="title">
      <img src="assets/img/title.png" alt="Brainy Monkey">
    </h1>

    <!-- Game Options in a Grid Layout -->
    <div class="dashboard">
      <a href="content/game.php" class="cage">
        <img src="assets/img/start.png" alt="Start Game" />
      </a>
      <a href="content/scoreBoard.php" class="cage">
        <img src="assets/img/score.png" alt="Scoreboard" />
      </a>
      <a href="content/dailyChallenge.php" class="cage">
        <img src="assets/img/daily.png" alt="Daily Challenge" />
      </a>
      <a href="content/leaderboard.php" class="cage">
        <img src="assets/img/leader.png" alt="Leaderboard" />
      </a>
    </div>

    <!-- Bottom Left: Exit Button -->
    <div class="exit-container">
    <button id="exit-game" onclick="exitGame()" >
            Exit
            <!-- <img src="../assets/img/exit.png" alt="Exit" class="exit-icon" /> -->
            <!-- Optionally use a Font Awesome icon, uncomment below if using Font Awesome -->
            <!-- <i class="fa fa-sign-out-alt exit-icon"></i> -->
        </button>
    </div>

    <!-- Bottom Right: Speaker & Settings -->
    <div class="asset-container">
      <a href="#">
        <img src="assets/img/speker.png" alt="Speaker" />
      </a>
      <a href="#">
        <img src="assets/img/settings.png" alt="Settings" />
      </a>
    </div>
  </div>

  <script src="assets/js/auth.js"></script>
  <script src="exit.js"></script>
</body>

</html>