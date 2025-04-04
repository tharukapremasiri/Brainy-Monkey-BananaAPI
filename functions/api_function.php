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

// Timer API
function getCurrentTimeFromAPI($timezone = 'Europe/London') {
    // Build the URL for the World Time API
    $url = "http://worldtimeapi.org/api/timezone/{$timezone}.json";
    
    // Fetch the data from the API
    $response = file_get_contents($url);
    
    if ($response === false) {
        // If there was an issue with fetching the data, return an error
        return "Unable to fetch time from API.";
    }

    // Decode the JSON response
    $data = json_decode($response, true);

    // Check if the data contains the required time information
    if (isset($data['datetime'])) {
        // Return the current datetime in the format 'Y-m-d H:i:s'
        return $data['datetime'];
    } else {
        // Return an error message if no valid data was returned
        return "Invalid data returned from the API.";
    }
}

// // Example usage
// $timezone = 'America/New_York'; // You can change this to any valid timezone, e.g., 'Asia/Kolkata'
// $currentTime = getCurrentTimeFromAPI($timezone);
// echo "Current time in {$timezone}: {$currentTime}";

?>
