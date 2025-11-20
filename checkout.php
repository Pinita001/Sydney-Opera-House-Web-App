<?php
// checkout.php - processes checkout and inserts bookings into DB, then redirects to confirmation.php
session_start();

// Guest checkout toggle
if ((isset($_GET['guest']) && $_GET['guest']=='1') || (isset($_POST['guest_checkout']) && $_POST['guest_checkout']=='1')) {
    $_SESSION['guest_checkout'] = true;
}

require_once 'db.php'; // expects $conn = new mysqli(...)

$is_guest = (empty($_SESSION['user_id']) && !empty($_SESSION['guest_checkout']));

// Require login unless guest checkout
if (!isset($_SESSION['user_id']) && empty($_SESSION['guest_checkout'])) {
    $_SESSION['flash_error'] = 'Please log in before checkout so we can record your booking under My Bookings.';
    header('Location: account.php');
    exit;
}

$user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null; // Set the user ID (null if guest)

// Inputs
$full_name = trim($_POST['full_name'] ?? '');
$email     = trim($_POST['email'] ?? '');
$phone     = trim($_POST['phone'] ?? '');
$cart_lines_raw = trim($_POST['cart_lines'] ?? '');
$total_price_in = trim($_POST['total_price'] ?? '0');

// If no cart data was sent, redirect back to cart
if ($cart_lines_raw === '') {
    $_SESSION['flash_error'] = 'Your cart is empty.';
    header('Location: carts.php');
    exit;
}

// Start transaction
$conn->begin_transaction();
$totalQty = 0;

try {
    // ---- Create order ----
    $total_price = (float)$total_price_in;
    $status = 'Confirmed';
    $stmt = $conn->prepare('INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, ?)');  // Prepare SQL to insert into "orders" table
    if ($user_id === null) {
        $null = null;
        $stmt->bind_param('ids', $null, $total_price, $status);
    } else {
        $stmt->bind_param('ids', $user_id, $total_price, $status); // Logged-in user
    }
    $stmt->execute();
    $order_id = $stmt->insert_id; // Capture new order ID
    $stmt->close();

    // ---- Parse cart lines: name||showtime||qty||price ----
    $lines = preg_split('/\r\n|\r|\n/', $cart_lines_raw);

    // Build all booking items for confirmation page
    $bookingItems = [];

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '') continue; // Skip empty lines

        // Split the line into parts
        $parts = explode('||', $line); 
        $name     = substr(trim($parts[0] ?? 'Untitled'), 0, 255);
        $showtime = substr(trim($parts[1] ?? ''), 0, 255);
        $qty      = (int)($parts[2] ?? 1);
        $price    = (float)($parts[3] ?? 0.0);
        $totalQty += $qty;

        // Try find show
        $show_id = null;
        $stmt = $conn->prepare('SELECT id FROM shows WHERE name = ? LIMIT 1');
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->bind_result($sid);
        if ($stmt->fetch()) $show_id = (int)$sid; // Found existing show
        $stmt->close();

         // If show not found, insert a new one
        if ($show_id === null) {
            $venue = 'Main Hall';
            $now   = date('Y-m-d H:i:s');
            $stmt = $conn->prepare('INSERT INTO shows (name, description, venue, date, price, image_url) VALUES (?, ?, ?, ?, ?, ?)');
            $desc = $showtime; // use showtime as temporary description
            $img  = '';
            $stmt->bind_param('ssssds', $name, $desc, $venue, $now, $price, $img);
            $stmt->execute();
            $show_id = $stmt->insert_id;
            $stmt->close();
        }

        // Insert order item
        $stmt = $conn->prepare('INSERT INTO order_items (order_id, show_id, quantity, price, show_time) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('iiids', $order_id, $show_id, $qty, $price, $showtime);
        $stmt->execute();
        $stmt->close();

        // Extract date/time for display
        $displayDate = '-';
        $displayTime = '-';
        $norm = trim(preg_replace('/\s+/', ' ', $showtime));
        if (preg_match('/([A-Za-z]+ \d{1,2}, \d{4})\s*-\s*([0-2]?\d:[0-5]\d\s*(AM|PM)?)/i', $norm, $m)) {
            $displayDate = $m[1];
            $displayTime = strtoupper(trim($m[2]));
        } elseif (preg_match('/(\d{4}-\d{2}-\d{2}).*?([0-2]?\d:[0-5]\d(\s*(AM|PM))?)/i', $norm, $m)) {
            $displayDate = date('F j, Y', strtotime($m[1]));
            $displayTime = strtoupper(trim($m[2]));
        } elseif (preg_match('/([0-2]?\d:[0-5]\d\s*(AM|PM))/i', $norm, $m)) {
            $displayDate = date('F j, Y');
            $displayTime = strtoupper(trim($m[1]));
        }

        // Build booking data for this item
        $bookingItems[] = [
            'booking_ref' => 'SOH' . date('ymdHis') . $order_id . rand(10,99),
            'show_title'  => $name,
            'venue'       => 'Sydney Opera House',
            'date'        => $displayDate,
            'time'        => $displayTime,
            'tickets'     => $qty,
            'total'       => number_format($price * $qty, 2)
        ];
    }

    // ---- Insert payment ----
    $amount = $total_price;
    $method = 'Credit Card';
    $pstatus = 'Paid';
    $stmt = $conn->prepare('INSERT INTO payments (order_id, payment_method, payment_status, amount) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('issd', $order_id, $method, $pstatus, $amount);
    $stmt->execute();
    $stmt->close();

    // Commit
    $conn->commit(); // All inserts successful → commit changes

    // Clear cart
    $_SESSION['clear_cart'] = true;

    // Save all bookings for confirmation.php
    $_SESSION['bookings'] = $bookingItems;

    // Redirect to confirmation page (using the first booking ref for URL)
    $ref = $bookingItems[0]['booking_ref'] ?? ('SOH' . date('ymdHis') . $order_id);
    header('Location: confirmation.php?ref=' . urlencode($ref));
    exit;

} catch (Throwable $e) {
    // ===================== ERROR HANDLING =====================
    // If anything fails, roll back the entire transaction
    $conn->rollback();
    $_SESSION['flash_error'] = 'Checkout failed. Please try again.';
    header('Location: carts.php');
    exit;
}
?>
