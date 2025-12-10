<?php
// add_question.php - CRUD for questions (Create/Update/Delete)
// Fixed: Absolute + safe
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
$msg = '';
$action = $_GET['action'] ?? 'add';
$q_id = (int)($_GET['id'] ?? 0);

if ($action == 'delete') {
    if (deleteQuestion($conn, $q_id)) {
        $msg = '<p class="success">Question deleted!</p>';
    } else {
        $msg = '<p class="error">Delete failed!</p>';
    }
    header("Location: /online_quiz_system/dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = $_POST['question'];
    $optA = $_POST['option_a'];
    $optB = $_POST['option_b'];
    $optC = $_POST['option_c'];
    $answer = $_POST['answer'];

    if ($action == 'add') {
        if (addQuestion($conn, $question, $optA, $optB, $optC, $answer, $user_id)) {
            $msg = '<p class="success">Question added!</p>';
        } else {
            $msg = '<p class="error">Add failed!</p>';
        }
    } elseif ($action == 'edit') {
        if (updateQuestion($conn, $q_id, $question, $optA, $optB, $optC, $answer)) {
            $msg = '<p class="success">Question updated!</p>';
        } else {
            $msg = '<p class="error">Update failed!</p>';
        }
    }
}

// If edit, fetch current data
$current_q = array();
if ($action == 'edit') {
    $sql = "SELECT * FROM questions WHERE id = $q_id";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $current_q = $result->fetch_assoc();
    } else {
        $msg = '<p class="error">Question not found!</p>';
    }
}
?>

<div style="max-width: 600px; margin: 0 auto;">
    <?php echo $msg; ?>

    <h2><?php echo ucfirst($action); ?> Question</h2>
    <form id="questionForm" method="POST" onsubmit="return validateForm('questionForm')">
        <textarea name="question" placeholder="Enter question" required><?php echo htmlspecialchars($current_q['question'] ?? ''); ?></textarea>
        <input type="text" name="option_a" placeholder="Option A" required value="<?php echo htmlspecialchars($current_q['option_a'] ?? ''); ?>">
        <input type="text" name="option_b" placeholder="Option B" required value="<?php echo htmlspecialchars($current_q['option_b'] ?? ''); ?>">
        <input type="text" name="option_c" placeholder="Option C" required value="<?php echo htmlspecialchars($current_q['option_c'] ?? ''); ?>">
        <input type="text" name="answer" placeholder="Correct Answer (e.g., '4')" required value="<?php echo htmlspecialchars($current_q['answer'] ?? ''); ?>">
        <input type="hidden" name="action" value="<?php echo $action; ?>">
        <?php if ($action == 'edit'): ?>
            <input type="hidden" name="id" value="<?php echo $q_id; ?>">
        <?php endif; ?>
        <button type="submit"><?php echo ucfirst($action); ?> Question</button>
    </form>

    <a href="/online_quiz_system/dashboard.php" class="btn">Back to Dashboard</a>
</div>

<?php include 'includes/footer.php'; ?>