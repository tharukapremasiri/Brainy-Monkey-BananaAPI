// Function to handle Google Sign-In response
function handleCredentialResponse(response) {
    const userObject = jwt_decode(response.credential);
    console.log(userObject);

    // You can send this information to your backend or handle the login process
    // Example: Sending data to the backend
    fetch('your_backend_login_url', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            email: userObject.email,
            name: userObject.name,
            token: response.credential
        })
    }).then(response => response.json())
      .then(data => {
          // Handle the response from your server
          console.log(data);
      }).catch(error => {
          console.log("Error during Google login:", error);
      });
}

// Optional: If you need to handle user sign-out
function signOut() {
    google.accounts.id.disableAutoSelect();
    google.accounts.id.revoke('user@example.com', function(response) {
        console.log(response);
    });
    window.location.href = 'login.php'; // Redirect to login page after logout
}
