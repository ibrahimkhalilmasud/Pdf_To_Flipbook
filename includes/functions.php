<?php
// includes/functions.php

// Function to sanitize user input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Function to redirect user
function redirect($location) {
    header("Location: $location");
    exit();
}

// Function to generate a random string
function generate_random_string($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $random_string = '';
    for ($i = 0; $i < $length; $i++) {
        $random_string .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $random_string;
}

// Function to check if a string is a valid email address
function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to get user information by ID
function get_user_by_id($user_id) {
    global $pdo; // Corrected from $conn to $pdo based on db_connect.php context
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bindParam(1, $user_id, PDO::PARAM_INT); // Changed from bind_param to bindParam
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC); // Changed from get_result and fetch_assoc
    return $result;
}

// Function to log errors
function log_error($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . "\n", 3, 'error.log');
}