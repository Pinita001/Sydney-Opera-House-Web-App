<?php
session_start(); 
include('db.php'); // Include database connection

// Only process the login logic when the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];     // Extract submitted credentials from the POST body and read user input from form submission
    $password = $_POST['password'];


    // Query to check if the user exists
    $sql = "SELECT id, full_name, email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email); // Bind the user-supplied value(s) to the prepared statement placeholders.
    $stmt->execute();
    $result = $stmt->get_result(); // Fetch the resulting user row so we can verify the password
    $user = $result->fetch_assoc();

    // Compare the submitted password with the stored hashed password securely
    if ($user && password_verify($password, $user['password'])) {
        // Store user info in session
        $_SESSION['user_id'] = $user['id'];   // read session data
        $_SESSION['user_full_name'] = $user['full_name'];
        }

        // Redirect to account page after successful login
        header('Location: account.php'); 
        exit(); // Stop script execution after header redirect
    } else {
        $error = "Invalid email or password!";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Process</title>
</head>
<!-- Output an error message if authentication fails or input is invalid. -->
<body>
    <h1>Login Processing...</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
        <p>You will be redirected to the login form in a moment.</p>
        <script>setTimeout(() => { window.location.href = 'account.html'; }, 3000);</script>  <!-- timer to go back to login page and retry -->
    <?php endif; ?>
</body>
</html>