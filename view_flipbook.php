<?php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$flipbook_id = $_GET['id'];
$sql = "SELECT * FROM flipbooks WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $flipbook_id]);
$flipbook = $stmt->fetch();

if (!$flipbook) {
    header("Location: dashboard.php");
    exit();
}

$password_required = !empty($flipbook['password']);
$password_correct = false;

if ($password_required && $_SERVER["REQUEST_METHOD"] == "POST") {
    if (password_verify($_POST['password'], $flipbook['password'])) {
        $password_correct = true;
    } else {
        $error = "Incorrect password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($flipbook['title']); ?> - PDF Flipbook</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/turn.min.js"></script>
</head>
<body>
    <div class="container">
        <h2><?php echo htmlspecialchars($flipbook['title']); ?></h2>
        <?php if ($password_required && !$password_correct): ?>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            <form action="" method="post">
                <input type="password" name="password" placeholder="Enter password" required>
                <button type="submit">Submit</button>
            </form>
        <?php else: ?>
            <div id="flipbook"></div>
            <div id="music-controls">
                <button id="prev-track">Previous</button>
                <button id="play-pause">Play/Pause</button>
                <button id="next-track">Next</button>
            </div>
            <audio id="background-music" loop>
                <source src="assets/music/playlist1/01_sky_kisses_earth.m4a" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        <?php endif; ?>
        <p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
    <?php if (!$password_required || $password_correct): ?>
    <script src="assets/js/flipbook.js"></script>
    <script>
        $(document).ready(function() {
            $('#flipbook').bind('start', function(event, pageObject, corner) {
                if (pageObject.page == 1) {
                    event.preventDefault();
                    alert('The page 1 does not exist');
                }
            });
        });
    </script>
    <?php endif; ?>
</body>
</html>