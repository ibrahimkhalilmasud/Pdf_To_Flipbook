<?php
// support.php
session_start();
require_once 'includes/db_connection.php';
require_once 'includes/functions.php';

// Check if user is logged in
if (!is_logged_in()) {
    redirect('login.php');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $subject = sanitize_input($_POST['subject']);
    $message = sanitize_input($_POST['message']);
    
    $query = "INSERT INTO support_tickets (user_id, subject, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $user_id, $subject, $message);
    
    if ($stmt->execute()) {
        $success_message = "Your support ticket has been submitted successfully.";
    } else {
        $error_message = "There was an error submitting your ticket. Please try again.";
        log_error("Failed to submit support ticket: " . $conn->error);
    }
    
    $stmt->close();
}

// Fetch existing tickets for the user
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM support_tickets WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$tickets = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support - PDF-to-Flipbook</title>
    <link rel="stylesheet" href="css/support_page.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

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

    <?php include 'includes/footer.php'; ?>

    <script src="js/support_page.js"></script>
</body>
</html>