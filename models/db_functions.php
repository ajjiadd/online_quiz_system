<?php

include '../config.php';  

// Get all questions for quiz
function getQuestions($conn) {
    $sql = "SELECT * FROM questions ORDER BY created_at DESC";  
    $result = $conn->query($sql);
    $questions = array(); 
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }
    }
    return $questions;
}

//Get questions by user_id 
function getUserQuestions($conn, $user_id) {
    $sql = "SELECT * FROM questions WHERE user_id = $user_id ORDER BY created_at DESC";
    $result = $conn->query($sql);
    $questions = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }
    }
    return $questions;
}

//Add question
function addQuestion($conn, $question, $optA, $optB, $optC, $answer, $user_id) {
    $sql = "INSERT INTO questions (question, option_a, option_b, option_c, answer, user_id) 
            VALUES ('$question', '$optA', '$optB', '$optC', '$answer', $user_id)";
    if ($conn->query($sql) === TRUE) {
        return true;  
    } else {
        return false;  
    }
}

//Delete function
function deleteQuestion($conn, $q_id) {
    $sql = "DELETE FROM questions WHERE id = $q_id";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Update question 
function updateQuestion($conn, $q_id, $question, $optA, $optB, $optC, $answer) {
    $sql = "UPDATE questions SET question='$question', option_a='$optA', option_b='$optB', 
            option_c='$optC', answer='$answer' WHERE id = $q_id";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Save score 
function saveScore($conn, $user_id, $score, $total) {
    $sql = "INSERT INTO scores (user_id, score, total_questions) VALUES ($user_id, $score, $total)";
    return $conn->query($sql) === TRUE;
}

// Get user scoresVIEW
function getUserScores($conn, $user_id) {
    $sql = "SELECT * FROM scores WHERE user_id = $user_id ORDER BY taken_at DESC LIMIT 5";  // Last 5
    $result = $conn->query($sql);
    $scores = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $scores[] = $row;
        }
    }
    return $scores;
}
?>