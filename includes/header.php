<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Quiz System</title>
    <link rel="stylesheet" href="../assets/style.css">  <!-- Link to CSS -->
</head>
<body>
    <header class="header">  <!-- Green header like BD Govt -->
        <div class="container">
            <h1>🧠 Online Quiz System</h1>  <!-- Emoji for fun -->
            <nav>
                <?php if (isset($_SESSION['user_id'])): ?>  <!-- If logged in -->
                    <a href="dashboard.php">Dashboard</a>
                    <a href="quiz.php">Take Quiz</a>
                    <?php if ($_SESSION['role'] == 'admin'): ?>
                        <a href="add_question.php">Manage Questions</a>
                    <?php endif; ?>
                    <a href="logout.php">Logout (<?php echo $_SESSION['username']; ?>)</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main class="container">  <!-- Main content area -->