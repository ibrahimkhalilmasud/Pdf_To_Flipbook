<?php
// support.php
session_start();

// Use a relative path
require_once __DIR__ . '/includes/db_connect.php';
require_once __DIR__ . '/includes/functions.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: Signin_SignUp.php");
    exit();
}

// Ensure $pdo is available from db_connect.php
if (!isset($pdo) || !$pdo) {
    die("Database connection failed. Please check your connection settings.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    
    $query = "INSERT INTO support_tickets (user_id, subject, message) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($query);
    if ($stmt) {
        $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $subject, PDO::PARAM_STR);
        $stmt->bindParam(3, $message, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            $success_message = "Your support ticket has been submitted successfully.";
        } else {
            $error_message = "There was an error submitting your ticket. Please try again.";
        }
        
        $stmt = null;
    } else {
        $error_message = "Error preparing the statement. Please try again.";
    }
}

// Fetch existing tickets for the user
$user_id = $_SESSION['user_id'];
$tickets = [];
$query = "SELECT * FROM support_tickets WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $pdo->prepare($query);
if ($stmt) {
    $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt = null;
} else {
    $error_message = "Error fetching tickets. Please try again.";
}

// Rest of the HTML remains the same
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support - PDF-to-Flipbook</title>
    <link rel="stylesheet" href="assets/css/support_page.css">
</head>
<body>
    <?php
    $header_path = __DIR__ . '/includes/header.php';
    if (file_exists($header_path)) {
        include $header_path;
    } else {
        echo "<header><h1>PDF-to-Flipbook</h1></header>";
    }
    ?>

    <main class="container">
        <h1>Support</h1>
        
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
            <div class="alert alert-error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <section id="submit-ticket">
            <h2>Submit a New Support Ticket</h2>
            <form action="support.php" method="POST">
                <div class="form-group">
                    <label for="subject">Subject:</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Ticket</button>
            </form>
        </section>

        <section id="ticket-history">
            <h2>Your Ticket History</h2>
            <?php if (empty($tickets)): ?>
                <p>You haven't submitted any support tickets yet.</p>
            <?php else: ?>
                <ul class="ticket-list">
                    <?php foreach ($tickets as $ticket): ?>
                        <li class="ticket-item">
                            <h3><?php echo htmlspecialchars($ticket['subject']); ?></h3>
                            <p class="ticket-message"><?php echo htmlspecialchars($ticket['message']); ?></p>
                            <p class="ticket-date">Submitted on: <?php echo date('F j, Y, g:i a', strtotime($ticket['created_at'])); ?></p>
                            <p class="ticket-status">Status: <?php echo ucfirst($ticket['status']); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
    </main>

    <?php
    $footer_path = __DIR__ . '/includes/footer.php';
    if (file_exists($footer_path)) {
        include $footer_path;
    } else {
        echo "<footer><p>&copy; " . date('Y') . " PDF-to-Flipbook. All rights reserved.</p></footer>";
    }
    ?>
    <script src="assets/js/support_page.js"></script>
</body>
</html>