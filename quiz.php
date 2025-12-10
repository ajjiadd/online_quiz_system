<?php
// quiz.php - Take quiz (View questions, submit for score - CRUD: View + Create score)
// Fixed: Absolute + safe checks
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
$questions = getQuestions($conn);

$msg = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Calculate score in PHP (simple)
    $score = 0;
    $total = count($questions);
    if (isset($_POST['answer'])) {
        foreach ($_POST['answer'] as $q_id => $selected) {
            foreach ($questions as $q) {
                if ($q['id'] == $q_id && $q['answer'] == $selected) {
                    $score++;
                }
            }
        }
        if (saveScore($conn, $user_id, $score, $total)) {
            $msg = "<p class='success'>Quiz submitted! Score: $score/$total</p>";
        }
    }
}
?>

<?php echo $msg ?? ''; ?>

<h2>Take Quiz (<?php echo count($questions); ?> Questions)</h2>
<?php if (empty($questions)): ?>
    <p class="error">No questions available. <a href="/online_quiz_system/add_question.php">Add some!</a></p>
<?php else: ?>
<form id="quizForm" method="POST" onsubmit="return calculateScore()">
    <?php foreach ($questions as $q): ?>
    <div class="quiz-question" style="margin-bottom: 20px; padding: 15px; background: white; border-radius: 5px;">
        <h4><?php echo $q['id'] . '. ' . htmlspecialchars($q['question']); ?></h4>
        <div class="quiz-option">
            <label><input type="radio" name="answer[<?php echo $q['id']; ?>]" value="<?php echo htmlspecialchars($q['option_a']); ?>" required data-correct="<?php echo htmlspecialchars($q['answer']); ?>"> A: <?php echo $q['option_a']; ?></label>
        </div>
        <div class="quiz-option">
            <label><input type="radio" name="answer[<?php echo $q['id']; ?>]" value="<?php echo htmlspecialchars($q['option_b']); ?>" data-correct="<?php echo htmlspecialchars($q['answer']); ?>"> B: <?php echo $q['option_b']; ?></label>
        </div>
        <div class="quiz-option">
            <label><input type="radio" name="answer[<?php echo $q['id']; ?>]" value="<?php echo htmlspecialchars($q['option_c']); ?>" data-correct="<?php echo htmlspecialchars($q['answer']); ?>"> C: <?php echo $q['option_c']; ?></label>
        </div>
    </div>
    <?php endforeach; ?>
    <input type="hidden" id="hiddenScore" name="score">
    <input type="hidden" id="hiddenTotal" name="total">
    <button type="submit">Submit Quiz</button>
</form>
<?php endif; ?>

<div id="quizResult" style="display: none;"></div>

<?php include 'includes/footer.php'; ?>