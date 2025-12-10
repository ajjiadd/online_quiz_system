<?php
// logout.php - Simple logout (Controller)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
session_destroy();  // Destroy session
header("Location: /online_quiz_system/index.html");  // Fixed absolute
exit();
?>