<?php
// dashboard.php - Dashboard after login (View user questions/scores)
// Fixed: Absolute links + safe session/config
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: /online_quiz_system/login.php");
    exit();
}

include 'config.php';
include 'includes/header.php';
include 'models/db_functions.php';

$user_id = $_SESSION['user_id'];
$questions = getUserQuestions($conn, $user_id);
$scores = getUserScores($conn, $user_id);
?>

<h2>Welcome, <?php echo $_SESSION['username']; ?>! (Role: <?php echo $_SESSION['role']; ?>)</h2>

<!-- User Questions Table (CRUD View) -->
<h3>Your Questions</h3>
<table>
    <tr><th>ID</th><th>Question</th><th>Actions</th></tr>
    <?php if (empty($questions)): ?>
        <tr><td colspan="3">No questions yet. <a href="/online_quiz_system/add_question.php" class="btn">Add One</a></td></tr>
    <?php else: ?>
        <?php foreach ($questions as $q): ?>
        <tr>
            <td><?php echo $q['id']; ?></td>
            <td><?php echo htmlspecialchars($q['question']); ?></td>
            <td>
                <a href="/online_quiz_system/add_question.php?action=edit&id=<?php echo $q['id']; ?>" class="btn">Edit</a>
                <a href="/online_quiz_system/add_question.php?action=delete&id=<?php echo $q['id']; ?>" class="btn" onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

<!-- Scores Table -->
<h3>Your Recent Scores</h3>
<table>
    <tr><th>Date</th><th>Score</th><th>Total</th></tr>
    <?php if (empty($scores)): ?>
        <tr><td colspan="3">No scores yet. Take a quiz!</td></tr>
    <?php else: ?>
        <?php foreach ($scores as $s): ?>
        <tr>
            <td><?php echo $s['taken_at']; ?></td>
            <td><?php echo $s['score']; ?>/<?php echo $s['total_questions']; ?></td>
            <td><?php echo $s['total_questions']; ?></td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

<a href="/online_quiz_system/quiz.php" class="btn">Take Quiz Now</a>
<a href="/online_quiz_system/add_question.php" class="btn">Add Question</a>
<?php if ($_SESSION['role'] == 'admin'): ?>
    <p><em>Admin: You can manage all questions.</em></p>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>