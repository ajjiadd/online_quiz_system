<?php
// config.php - Simple DB connection using mysqli (beginner-friendly, no PDO)
// This is the Model part: Connects to quiz_db database

$servername = "localhost";  // XAMPP default
$username = "root";         
$password = "";             
$dbname = "quiz_db";       

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);  // Error if connection fails
}

// Set charset to UTF-8 for Bengali support
$conn->set_charset("utf8");


?>