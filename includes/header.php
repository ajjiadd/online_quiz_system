<?php
// includes/header.php - Common header with nav (BD Govt style: green header)
// Fixed: Conditional session_start to avoid "already active" notice
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Start only if not active
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Quiz System</title>
    <link rel="stylesheet" href="/online_quiz_system/assets/style.css">  <!-- Fixed: Absolute path from root -->
</head>
<body>
    <header class="header">  <!-- Green header like BD Govt -->
        <div class="container">
            <h1>🧠 Online Quiz System</h1>  <!-- Emoji for fun -->
            <nav>
                <?php if (isset($_SESSION['user_id'])): ?>  <!-- If logged in -->
                    <a href="/online_quiz_system/dashboard.php">Dashboard</a>  <!-- Absolute links for safety -->
                    <a href="/online_quiz_system/quiz.php">Take Quiz</a>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                        <a href="/online_quiz_system/add_question.php">Manage Questions</a>
                    <?php endif; ?>
                    <a href="/online_quiz_system/logout.php">Logout (<?php echo $_SESSION['username'] ?? ''; ?>)</a>
                <?php else: ?>
                    <a href="/online_quiz_system/login.php">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main class="container">  <!-- Main content area -->