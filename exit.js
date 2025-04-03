function exitGame() {
    // Ask for confirmation before exiting
    const confirmExit = confirm("Are you sure you want to exit the game?");

    if (confirmExit) {
        // Send an AJAX request to a PHP file to destroy the session
        fetch('exit.php')
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    // Redirect to the homepage or login page after exiting
                    window.location.href = "content/login.php"; // Or any page you want to redirect to
                } else {
                    alert('There was an error while trying to exit. Please try again.');
                }
            })
            .catch(error => console.error('Error:', error));
    }
}
