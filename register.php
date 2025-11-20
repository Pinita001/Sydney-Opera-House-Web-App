<?php
session_start();
include('db.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];   // read submitted form fields
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if ($password === $password_confirm) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);  // hash the user's password securely before storing

        // Insert user data into the database
        $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";   // insert new user record into users table
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $full_name, $email, $hashed_password); // bind input parameter(s) to prepared SQL statemen

        if ($stmt->execute()) {
            $_SESSION['user_id'] = $conn->insert_id; // Get the ID of the new user // set session variables (e.g., user_id) after successful registration
            $_SESSION['user_full_name'] = $full_name;   // set session variables (e.g., user_id) after successful registration
            
            // Redirect directly to the account dashboard
            header('Location: account.php');    // redirect user to login or account page after registration
            exit(); // Stop script execution immediately
        } else {
            // Assuming the error is a duplicate email
            $error = "Registration failed. Email may already be in use.";
        }
    } else {
        $error = "Passwords do not match!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Process</title>
</head>

<!-- registration form UI and messages -->
<body>
    <h1>Registration Processing...</h1>
    <?php if (isset($error)): ?>
        <!-- Initialize session, load DB, and process registration when form is submitted -->
        <p style="color: red;"><?php echo $error; ?></p>    <!-- // output validation or duplicate warning to user -->
        <p>You will be redirected back to the registration form in a moment.</p>
        <script>setTimeout(() => { window.location.href = 'account.html'; }, 3000);</script>
    <?php endif; ?>
</body>
</html>