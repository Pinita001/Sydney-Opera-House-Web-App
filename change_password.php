<?php

session_start();
require_once 'db.php'; // expects $conn = new mysqli(...)

function respond_and_exit($message, $ok=false) {
    // HTML response and HTML portion for the change password interface
    echo "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Change Password</title><link rel='stylesheet' href='styles.css'></head><body>";
    echo "<section class='checkout-container'><div class='container'>";
    echo "<h2 class='section-title'>Change Password</h2>";
    echo "<p style='color:" . ($ok ? "green" : "crimson") . "; font-weight:600;'>" . htmlspecialchars($message) . "</p>";   // display success or error message to the user
    echo "<p><a class='btn' href='account.html'>Back to Account</a></p>";
    echo "</div></section></body></html>";
    exit;
}

// Ensure POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {    // ensure password change logic only runs on POST submission
    respond_and_exit('Invalid request method.');
}

// Identify logged-in user (prefer id)
$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;  // check if user session is active to confirm user is logged in
$user_email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

if ($user_id <= 0 && $user_email === '') {
    respond_and_exit('You must be logged in to change your password.');
}

// Validate fields
$current = isset($_POST['current_password']) ? trim($_POST['current_password']) : '';   // retrieve submitted password fields from form
$new     = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
$confirm = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

if ($current === '' || $new === '' || $confirm === '') {
    respond_and_exit('Please complete all fields.');
}
if ($new !== $confirm) {
    respond_and_exit('New password and confirmation do not match.');
}
if (strlen($new) < 6) { // validate minimum password length requirements
    respond_and_exit('New password must be at least 6 characters.');
}

// Fetch user row
if ($user_id > 0) {
    $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE id = ? LIMIT 1");   // prepare SQL statement for secure password update (prevents SQL injection)
    $stmt->bind_param("i", $user_id);   // bind input variables to prepared SQL statement parameters
} else {
    $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $user_email);
}
if (!$stmt->execute()) {    // execute prepared SQL statement to update password in database
    respond_and_exit('Database error (fetch).');
}
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    respond_and_exit('Account not found.');
}

// Verify current password
$stored = (string)$user['password'];
$valid_current = false;

// Try password_verify (hashed case)
if (password_get_info($stored)['algo'] !== 0) {
    $valid_current = password_verify($current, $stored);   // verify old password matches the existing hashed password in DB
} else {
    // Fallback: legacy plain text comparison
    $valid_current = hash_equals($stored, $current);
}

if (!$valid_current) {
    respond_and_exit('Current password is incorrect.');
}

// Hash the new password
$new_hash = password_hash($new, PASSWORD_DEFAULT);  // hash the new password securely before saving to DB

// Update
$upd = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");    // prepare SQL statement for secure password update (prevents SQL injection)
$uid = (int)$user['id'];
$upd->bind_param("si", $new_hash, $uid);    // bind input variables to prepared SQL statement parameters

if ($upd->execute()) {  // execute prepared SQL statement to update password in database
    $upd->close();
    respond_and_exit('Password updated successfully.', true);
} else {
    $upd->close();
    respond_and_exit('Failed to update password. Please try again.');
}
?>