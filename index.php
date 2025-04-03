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
      <a href="profile.html">
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
      <a href="scoreboard.html" class="cage">
        <img src="assets/img/score.png" alt="Scoreboard" />
      </a>
      <a href="assets.html" class="cage">
        <img src="assets/img/daily.png" alt="Daily Challenge" />
      </a>
      <a href="progress.html" class="cage">
        <img src="assets/img/leader.png" alt="Leaderboard" />
      </a>
    </div>

    <!-- Bottom Left: Exit Button -->
    <div class="exit-container">
      <button id="exit-game">
        <img src="assets/img/exit.png" alt="Exit" />
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
  <script src="assets/js/script.js"></script>
</body>

</html>