<?php

$servername = "localhost";  
$username = "root";         
$password = "";             
$dbname = "quiz_db";        

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);  // Error if connection fails
}

// Set Bengali language support
$conn->set_charset("utf8");

?>