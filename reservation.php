<!-- Handles Dining/Experience reservation submission -->
<?php 
session_start(); 
require_once 'db.php'; 
function respond_and_exit($msg, $ok=true) { 
    if ($ok) { 
        $_SESSION['flash_success'] = $msg; 
        header('Location: account.php?tab=reservations'); // redirect after successful reservation
        } else { 
            $_SESSION['flash_error'] = $msg; 
            header('Location: experiences.php'); // redirect after unsuccessful reservation
        } 
        exit; 
            } 
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') { // only run reservation logic when form is submitted via POST
                respond_and_exit('Invalid request.', false); 
                } 
                $full_name = trim($_POST['full_name'] ?? ''); // read submitted reservation fields from form
                $email = trim($_POST['email'] ?? ''); 
                $phone = trim($_POST['phone'] ?? ''); 
                $date = trim($_POST['resDate'] ?? ''); 
                $time = trim($_POST['time'] ?? ''); 
                $guests = intval($_POST['guests'] ?? 0); 
                $notes = trim($_POST['notes'] ?? ''); 
                if ($full_name==='' || $email==='' || $phone==='' || $date==='' || $time==='' || $guests<1) { 
                    respond_and_exit('Missing or invalid fields. Please go back and complete the form.'); } 
                if ($conn->connect_error) { 
                    respond_and_exit('Database connection error.'); 
                    } 
                $conn->query("CREATE TABLE IF NOT EXISTS reservations ( 
                id INT AUTO_INCREMENT PRIMARY KEY, 
                full_name VARCHAR(255) NOT NULL, 
                email VARCHAR(255) NOT NULL, phone VARCHAR(50) NOT NULL, 
                date DATE NOT NULL, time TIME NOT NULL, 
                guests INT NOT NULL, 
                notes VARCHAR(500), 
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP )"); 
                
                $stmt = $conn->prepare("INSERT INTO reservations (full_name, email, phone, date, time, guests, notes) VALUES (?, ?, ?, ?, ?, ?, ?)");  // prepare parameterized INSERT to store reservation securely
                $stmt->bind_param('sssssis', $full_name, $email, $phone, $date, $time, $guests, $notes); // bind input values to prepared SQL placeholders
                
                if ($stmt->execute()) { // execute SQL to create reservation record
                    respond_and_exit('Your reservation has been received.'); 
                    } else { respond_and_exit('Failed to save reservation. Please try again later.', false); 
                    } 
                    ?>