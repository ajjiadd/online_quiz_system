<?php
// login.php - Simple login/signup form (Controller: Handle POST)
// Fixed: Absolute redirects + safe includes
include 'config.php';
include 'includes/header.php';

$msg = '';  // Message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';  // Login or signup
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($action == 'signup') {
        // Simple signup (no hash, as per your request)
        $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'user')";
        if ($conn->query($sql) === TRUE) {
            $msg = '<p class="success">Signup successful! Please login.</p>';
        } else {
            $msg = '<p class="error">Error: Username exists!</p>';
        }
    } elseif ($action == 'login') {
        // Simple login (plain text check)
        $sql = "SELECT id, username, password, role FROM users WHERE username='$username' AND password='$password'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            header("Location: /online_quiz_system/dashboard.php");  // Fixed absolute
            exit();
        } else {
            $msg = '<p class="error">Invalid username/password!</p>';
        }
    }
}
?>

<div style="max-width: 600px; margin: 0 auto; padding: 20px;">
    <?php echo $msg; ?>

    <!-- Signup Form -->
    <h3>Sign Up</h3>
    <form id="signupForm" method="POST" onsubmit="return validateForm('signupForm')">
        <input type="hidden" name="action" value="signup">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign Up</button>
    </form>

    <!-- Login Form -->
    <h3>Login</h3>
    <form id="loginForm" method="POST" onsubmit="return validateForm('loginForm')">
        <input type="hidden" name="action" value="login">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <p><small>Demo: Admin - admin / admin@00</small></p>
</div>

<?php include 'includes/footer.php'; ?>