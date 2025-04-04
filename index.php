<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Brainy Monkey</title>
  <link rel="stylesheet" href="assets/css/style.css" />
  <script src="https://accounts.google.com/gsi/client" async defer></script>
  <style>
    
  </style>
</head>

<body>
  <div class="container">
    <!-- Auth Buttons at the Top Right -->
    <div class="auth-buttons">
      <a href="content/login.php" id="login-button" class="btn">Login</a>
      <!-- <button id="logout-button" class="btn hidden" onclick="signOut()">
        Logout
      </button> -->
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
        <a href="content/leaderboard.php" class="button">
        <p>How to play</p>
      </a>
    </div>

    <!-- Bottom Right: Speaker & Settings -->
    <div class="asset-container">
    <a href="#" id="toggle-music">
        <img src="assets/img/speker.png" alt="Speaker" />
      </a>
      <a href="#">
        <img src="assets/img/settings.png" alt="Settings" />
      </a>
    </div>
  </div>
  <!-- Background Music (Initially paused) -->
  <audio id="background-music" src="assets/music/music.mp3" preload="auto" loop></audio>

  <script src="assets/js/auth.js"></script>
  <script src="exit.js"></script>
  
  <!-- JavaScript to control music -->
  <script>
    let music = document.getElementById('background-music');
    let toggleMusicButton = document.getElementById('toggle-music');

    // Initially, the music will be paused
    let isPlaying = false;

    // Toggle music play/pause when clicking on the speaker icon
    toggleMusicButton.addEventListener('click', function() {
      if (isPlaying) {
        music.pause();  // Pause the music
      } else {
        music.play();  // Play the music
      }
      isPlaying = !isPlaying;  // Toggle the play state
    });
  </script>
</body>

</html>