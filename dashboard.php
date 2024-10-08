<?php
session_start();
require_once 'includes/db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: Signin_SignUp.php");
    exit();
}

// Fetch user's flipbooks
$sql = "SELECT * FROM flipbooks WHERE user_id = :user_id ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$flipbooks = $stmt->fetchAll();

// Count total and free flipbooks
$total_flipbooks = count($flipbooks);
$free_flipbooks = 5; // Assuming 5 free flipbooks per user
$used_flipbooks = min($total_flipbooks, $free_flipbooks);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Heyzine</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        <div class="toolbar">
            <div class="left-tools">
                <button><i class="fas fa-trash"></i></button>
                <button><i class="fas fa-book"></i></button>
                <button><i class="fas fa-copy"></i></button>
                <button><i class="fas fa-th"></i></button>
                <button><i class="fas fa-list"></i></button>
                <button><i class="fas fa-sort-alpha-down"></i></button>
                <button><i class="fas fa-calendar"></i></button>
                <button><i class="fas fa-eye"></i></button>
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="center-tools">
                <select>
                    <option>Show all</option>
                </select>
                <button class="new-flipbook">New flipbook</button>
            </div>
            <div class="right-tools">
                <span><?php echo $used_flipbooks; ?> out of <?php echo $free_flipbooks; ?> free flipbooks in use</span>
                <button class="buy-more">Buy more</button>
                <button class="subscribe">Subscribe</button>
            </div>
        </div>

        <div class="flipbooks-grid">
            <?php foreach ($flipbooks as $flipbook): ?>
            <div class="flipbook-card">
                <h3><?php echo htmlspecialchars($flipbook['title']); ?></h3>
                <p><?php echo date('F j, Y', strtotime($flipbook['created_at'])); ?></p>
                <img src="assets/uploads/covers/<?php echo $flipbook['filename']; ?>.jpg" alt="<?php echo htmlspecialchars($flipbook['title']); ?> cover">
                <div class="views"><i class="fas fa-eye"></i> <?php echo rand(1, 10); ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script src="assets/js/dashboard.js"></script>
</body>
</html>