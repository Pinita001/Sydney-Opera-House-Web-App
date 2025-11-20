<?php
// Handles logout process including session destruction and redirect
session_start();
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();  // enter conditional branch
    setcookie(session_name(), '', time() - 42000,   // delete session cookie in browser
        $params["path"], $params["domain"], // conditional logic
        $params["secure"], $params["httponly"]
    );
}
session_destroy();  // destroy session data on the server
// Redirect back to account page
header('Location: account.html');
exit;
?>