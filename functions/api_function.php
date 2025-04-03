<?php
function getGameQuestion() {
    $apiUrl = "http://marcconrad.com/uob/banana/api.php"; // API URL
    $response = file_get_contents($apiUrl);

    if ($response === FALSE) {
        return ["error" => "Failed to fetch question"];
    }

    $data = json_decode($response, true);

    return [
        "image_url" => $data["question"] ?? "../assets/img/default.png", // Question Image
        "correct_answer" => $data["solution"] ?? null // Correct Answer
    ];
}
?>
