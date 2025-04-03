function handleCredentialResponse(response) {
    const data = jwt_decode(response.credential); // Decode JWT token
    sessionStorage.setItem("user", JSON.stringify(data)); // Store user in session

    // Redirect to index page after login
    window.location.href = "index.html";
}

function checkLoginStatus() {
    const user = JSON.parse(sessionStorage.getItem("user"));

    if (user) {
        document.getElementById("login-button").classList.add("hidden");
        document.getElementById("logout-button").classList.remove("hidden");
    }
}

function signOut() {
    sessionStorage.removeItem("user");
    window.location.href = "index.html"; // Redirect to home after logout
}

document.addEventListener("DOMContentLoaded", checkLoginStatus);


