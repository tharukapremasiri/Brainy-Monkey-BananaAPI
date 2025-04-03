<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$databasename = 'game_db';


$conn = new mysqli($hostname, $username, $password, $databasename);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
else{
}  
  
?>
