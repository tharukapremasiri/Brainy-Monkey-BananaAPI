<?php
session_start();

// Destroy session to log out the user
session_unset();
session_destroy();

// Return a JSON response indicating success
echo json_encode(['status' => 'success']);
exit();
?>

