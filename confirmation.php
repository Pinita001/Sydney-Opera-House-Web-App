<?php
session_start();
require_once 'db.php';

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);  // assign or retrieve session variable values

// Get all booked shows from session
$bookings = $_SESSION['bookings'] ?? [];  // assign or retrieve session variable values

// Fallback for older code that only stored one booking
if (empty($bookings) && isset($_SESSION['last_booking'])) {   // check if session variables exist to determine login status or user info
    $bookings = [$_SESSION['last_booking']];  // assign or retrieve session variable values
}

// Fallback if nothing found
if (empty($bookings)) {
    $bookings = [[
        'booking_ref' => '—',
        'show_title'  => 'Your Booking',
        'venue'       => 'Sydney Opera House',
        'date'        => '—',
        'time'        => '—',
        'tickets'     => 0,
        'total'       => '0.00'
    ]];
}

// Button setup
$btnLabel = $isLoggedIn ? 'My Bookings' : 'Back to Home';
$btnHref  = $isLoggedIn ? 'account.php?tab=bookings' : 'index.html';
?>
<!-- HTML structure for the confirmation page display -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Booking Confirmed</title>
  <link rel="stylesheet" href="styles.css" />
  <style>
    body {font-family: Arial, sans-serif; background: #f8f8f8; margin: 0; padding: 0;}
    .confirm-wrap {max-width: 900px; margin: 40px auto; background: #fff; padding: 30px 40px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);}
    .checkmark {width:72px; height:72px; border-radius:50%; background:#e7f8ed; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;}
    .checkmark:before {content:"✓"; font-size:40px; color:#1a7f37; line-height:1;}
    .confirm-title {text-align:center; font-weight:800; font-size:28px; margin:8px 0 6px;}
    .confirm-sub {text-align:center; color:#666; margin-bottom:28px;}
    table {width:100%; border-collapse:collapse; margin-bottom:24px;}
    th, td {padding:10px 14px; border-bottom:1px solid #ddd; text-align:left;}
    th {background:#f9f9f9; font-weight:700;}
    .btn-cta {display:inline-block; background:#d22; color:#fff; border:none; border-radius:8px; padding:12px 18px; font-weight:700; text-decoration:none;}
    .btn-cta:hover {filter:brightness(.95);}
    .center {text-align:center;}
  </style>
</head>

<!-- Body section: main visible content including confirmation detail -->
<body>
  <main class="confirm-wrap">
    <div class="checkmark"></div>
    <h1 class="confirm-title">Thank you for your purchase!</h1>
    <p class="confirm-sub">Your booking has been confirmed. A confirmation email has been sent to your email address.</p>

    <h2 style="margin-bottom:10px;">Booking Details</h2>
    <table>
      <tr>
        <th>Booking Reference</th>
        <th>Date</th>
        <th>Time</th>
        <th>Show</th>
        <th>Venue</th>
        <th>Tickets</th>
        <th>Total</th>
      </tr>
      <?php foreach ($bookings as $b): ?>
        <!-- Initialize session and database connection, then fetch order details -->
      <tr>
        <td><?= htmlspecialchars($b['booking_ref']) ?></td>
        <td><?= htmlspecialchars($b['date']) ?></td>
        <td><?= htmlspecialchars($b['time']) ?></td>
        <td><?= htmlspecialchars($b['show_title']) ?></td>
        <td><?= htmlspecialchars($b['venue']) ?></td>
        <td><?= (int)$b['tickets'] ?></td>
        <td>$<?= htmlspecialchars($b['total']) ?></td>
      </tr>
      <?php endforeach; ?>
    </table>

    <div class="center">
      <a class="btn-cta" href="<?= $btnHref ?>"><?= $btnLabel ?></a>
    </div>

    <p class="center" style="margin-top:22px;color:#666;">Please arrive at least 30 minutes before the show starts.</p>
  </main>
  <script>
  window.addEventListener('load', function () {
    localStorage.clear();
    sessionStorage.clear();
  });
</script>  
</body>
</html>
