<?php
// config.php - Simple DB connection using mysqli (beginner-friendly, no PDO)
// This is the Model part: Connects to quiz_db database

$servername = "localhost";  // XAMPP default
$username = "root";         // XAMPP default user
$password = "";             // XAMPP default password (empty)
$dbname = "quiz_db";        // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);  // Error if connection fails
}

// Set charset to UTF-8 for Bengali support
$conn->set_charset("utf8");

// This file will be included in other PHP files for DB access
?>