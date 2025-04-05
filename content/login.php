<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Brainy Monkey</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/jwt-decode@3.1.2/build/jwt-decode.min.js"></script> <!-- for decoding JWT -->
    <style>
        /* Your CSS styles are unchanged */
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
            margin-right: 10px;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

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

            <!-- Manual Login -->
            <form action="login.php" method="post" class="manual-login-form">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="btn">Login</button>
            </form>

            <div class="footer-links">
                <a href="../index.php" class="btn-link">Back to Home</a>
                <a href="forgot-password.html">Forgot Password?</a>
            </div>

            <div class="divider">OR</div>

            <!-- Google Sign-In -->
            <div id="g_id_onload"
                data-client_id="642393977443-30q3i0up05mhrfu6arr22f0j5kp8m9d4.apps.googleusercontent.com"
                data-callback="handleCredentialResponse"
                data-auto_prompt="false">
            </div>
            <div class="g_id_signin" data-type="standard"></div>
        </div>
    </div>

    <script>
        function handleCredentialResponse(response) {
            const userObject = jwt_decode(response.credential);
            console.log("Google User Info:", userObject);

            // Send data to backend PHP file
            fetch("google-login-handler.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    email: userObject.email,
                    name: userObject.name,
                    picture: userObject.picture,
                    token: response.credential
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Login successful! Redirecting...");
                    window.location.href = "../index.php"; // redirect to your dashboard/homepage
                } else {
                    alert("Login failed: " + data.message);
                }
            })
            .catch(err => console.error("Login error:", err));
        }
    </script>
</body>

</html>
