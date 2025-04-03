<?php


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brainy Monkey</title>
    <link rel="stylesheet" href="../assets/css/style.css">
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
          <img src="../assets/img/monkey-face.png" alt="Profile" />
        </a>
      </div>

        <!-- Centered Title (No gap after login button) -->
        <h1 class="title">
            <img src="../assets/img/title.png" alt="Brainy Monkey">
        </h1>

       
      
    </div>

    <script src="assets/js/auth.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
