<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Brainy Monkey</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <style>
        /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
}

.login-box {
    background-color: white;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 350px;
    text-align: center;
}

h2 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
}

button, .g_id_signin {
    width: 100%;
    padding: 12px;
    margin-bottom: 10px;
    border: none;
    background-color: #4285F4;
    color: white;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
}

button:hover, .g_id_signin:hover {
    background-color: #357AE8;
}

.divider {
    margin: 20px 0;
    font-size: 16px;
    color: #555;
}

.manual-login-form input {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

.footer-links a {
    color: #4285F4;
    font-size: 14px;
    text-decoration: none;
}

.footer-links a:hover {
    text-decoration: underline;
}

/* Back to home button styling */
.btn {
    background-color: #4285F4;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
}

.btn:hover {
    background-color: #357AE8;
}

    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Login to Brainy Monkey</h2>

            <!-- Google Sign-In Button -->
            <div id="g_id_onload"
                data-client_id="YOUR_GOOGLE_CLIENT_ID"
                data-callback="handleCredentialResponse">
            </div>
            <div class="g_id_signin" data-type="standard"></div>

            <div class="divider">OR</div>

            <!-- Manual Login Form (Optional) -->
            <form action="your_login_backend.php" method="post" class="manual-login-form">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="btn">Login</button>
            </form>

            <div class="footer-links">
                <a href="../index.php" class="btn" style="color: while; font-style: none;">Back to Home</a>
                <a href="forgot-password.html">Forgot Password?</a>
            </div>
        </div>
    </div>

    <script src="assets/js/auth.js"></script>
</body>

</html>

