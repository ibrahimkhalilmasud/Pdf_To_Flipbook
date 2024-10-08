<?php
session_start();
require_once 'includes/db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user information
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate and update user information
    if ($new_password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $update_stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        $update_stmt->execute([$new_username, $new_email, $user_id]);

        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $password_stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $password_stmt->execute([$hashed_password, $user_id]);
        }

        $success = "Account information updated successfully.";
        
        // Refresh user information
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings - Heyzine</title>
    <link rel="stylesheet" href="assets/css/account.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="assets/images/logo.png" alt="Heyzine Logo">
            <span>Heyzine</span>
        </div>
        <nav>
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="stats.php"><i class="fas fa-chart-bar"></i> Stats</a>
            <a href="upload.php"><i class="fas fa-plus"></i> New flipbook</a>
            <a href="account.php" class="active"><i class="fas fa-user"></i> Account</a>
            <a href="support.php"><i class="fas fa-question-circle"></i> Support</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </header>

    <main>
        <div class="container">
            <h1>Account Settings</h1>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            <form action="account.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="new_password">New Password (leave blank to keep current password)</label>
                    <div class="password-input-wrapper">
                        <input type="password" id="new_password" name="new_password">
                        <button type="button" class="toggle-password">Show</button>
                    </div>
                    <meter id="password-strength-meter" min="0" max="5" value="0"></meter>
                    <p id="password-strength-text"></p>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <div class="password-input-wrapper">
                        <input type="password" id="confirm_password" name="confirm_password">
                        <button type="button" class="toggle-password">Show</button>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update Account</button>
            </form>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="assets/js/account.js"></script>
</body>
</html>