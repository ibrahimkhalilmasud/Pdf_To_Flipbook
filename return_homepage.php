<?php
session_start();
require_once 'includes/db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signup.php");
    exit();
}

// Fetch user information
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch user's flipbooks
$stmt = $pdo->prepare("SELECT * FROM flipbooks WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
$stmt->execute([$user_id]);
$recent_flipbooks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Back - Heyzine</title>
    <link rel="stylesheet" href="assets/css/return_homepage.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</head>
<body>
    <header>
        <div class="logo">
            <img src="assets/images/logo.png" alt="Heyzine Logo">
            <span>Heyzine</span>
        </div>
        <nav>
            <a href="return_homepage.php" class="active"><i class="fas fa-home"></i> Home</a>
            <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="stats.php"><i class="fas fa-chart-bar"></i> Stats</a>
            <a href="upload.php"><i class="fas fa-plus"></i> New flipbook</a>
            <a href="account.php"><i class="fas fa-user"></i> Account</a>
            <a href="support.php"><i class="fas fa-question-circle"></i> Support</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </header>

    <main>
        <div class="container">
            <h1>Welcome back, <?php echo htmlspecialchars($user['username']); ?>!</h1>
            
            <section class="quick-actions">
                <h2>Quick Actions</h2>
                <div class="action-buttons">
                    <a href="upload.php" class="btn btn-primary"><i class="fas fa-plus"></i> Create New Flipbook</a>
                    <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-book"></i> View All Flipbooks</a>
                </div>
            </section>

            <section class="recent-flipbooks">
                <h2>Your Recent Flipbooks</h2>
                <div class="flipbook-grid">
                    <?php foreach ($recent_flipbooks as $flipbook): ?>
                        <div class="flipbook-card">
                            <img src="assets/images/flipbook-cover-placeholder.jpg" alt="<?php echo htmlspecialchars($flipbook['title']); ?>" class="flipbook-cover">
                            <h3><?php echo htmlspecialchars($flipbook['title']); ?></h3>
                            <p>Created: <?php echo date('M d, Y', strtotime($flipbook['created_at'])); ?></p>
                            <a href="view_flipbook.php?id=<?php echo $flipbook['id']; ?>" class="btn btn-view">View</a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if (count($recent_flipbooks) == 0): ?>
                    <p>You haven't created any flipbooks yet. <a href="upload.php">Create your first flipbook now!</a></p>
                <?php endif; ?>
            </section>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Heyzine. All rights reserved.</p>
    </footer>

    <script src="assets/js/return_homepage.js"></script>
</body>
</html>