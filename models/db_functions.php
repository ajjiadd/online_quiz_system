<?php
// models/db_functions.php - Simple functions for DB operations (CRUD)
// Fixed: Safe include with warning, not die - continues if config missing

$config_included = false;
if (file_exists('../config.php')) {
    include '../config.php';  // Path from models/ to root/config.php
    $config_included = true;
} else {
    error_log("Warning: config.php not found in root!");  // Log only, no stop
}

// Functions - but check if $conn exists before using
function getQuestions($conn) {
    if (!$conn) return [];  // Safe if no conn
    $sql = "SELECT * FROM questions ORDER BY created_at DESC";
    $result = $conn->query($sql);
    $questions = array();
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }
    }
    return $questions;
}

function getUserQuestions($conn, $user_id) {
    if (!$conn) return [];
    $sql = "SELECT * FROM questions WHERE user_id = $user_id ORDER BY created_at DESC";
    $result = $conn->query($sql);
    $questions = array();
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }
    }
    return $questions;
}

function addQuestion($conn, $question, $optA, $optB, $optC, $answer, $user_id) {
    if (!$conn) return false;
    $sql = "INSERT INTO questions (question, option_a, option_b, option_c, answer, user_id) 
            VALUES ('$question', '$optA', '$optB', '$optC', '$answer', $user_id)";
    return $conn->query($sql) === TRUE;
}

function deleteQuestion($conn, $q_id) {
    if (!$conn) return false;
    $sql = "DELETE FROM questions WHERE id = $q_id";
    return $conn->query($sql) === TRUE;
}

function updateQuestion($conn, $q_id, $question, $optA, $optB, $optC, $answer) {
    if (!$conn) return false;
    $sql = "UPDATE questions SET question='$question', option_a='$optA', option_b='$optB', 
            option_c='$optC', answer='$answer' WHERE id = $q_id";
    return $conn->query($sql) === TRUE;
}

function saveScore($conn, $user_id, $score, $total) {
    if (!$conn) return false;
    $sql = "INSERT INTO scores (user_id, score, total_questions) VALUES ($user_id, $score, $total)";
    return $conn->query($sql) === TRUE;
}

function getUserScores($conn, $user_id) {
    if (!$conn) return [];
    $sql = "SELECT * FROM scores WHERE user_id = $user_id ORDER BY taken_at DESC LIMIT 5";
    $result = $conn->query($sql);
    $scores = array();
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $scores[] = $row;
        }
    }
    return $scores;
}
?>