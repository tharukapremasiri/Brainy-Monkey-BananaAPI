<?php
session_start();

// Get raw POST data
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['email']) || !isset($data['name'])) {
    echo json_encode(["success" => false, "message" => "Missing user data"]);
    exit;
}

// Optionally verify the token here using Google's API

// Example: Save user info in session (you could insert/update to DB instead)
$_SESSION['email'] = $data['email'];
$_SESSION['name'] = $data['name'];
$_SESSION['picture'] = $data['picture'];

// Success response
echo json_encode(["success" => true]);
?>