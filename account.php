<?php
session_start();
require_once 'db.php';
// When user submits "My Profile" form, handle name/phone update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_profile_update'])) {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['flash_error'] = 'Please log in to update your profile.';
        header('Location: account.php?tab=profile');
        exit;
    }
    $uid = (int)$_SESSION['user_id']; // Current logged-in user's ID
    $full_name = isset($_POST['full_name']) ? trim($_POST['full_name']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

    // Basic server-side validation for phone (allow +, spaces, digits, dashes)
    if ($phone !== '' && !preg_match('/^[+0-9\s\-()]{6,20}$/', $phone)) {
        $_SESSION['flash_error'] = 'Invalid phone format.';
        header('Location: account.php?tab=profile');
        exit;
    }

    // Update user's info in DB
    $sql = "UPDATE users SET full_name = ?, phone = ? WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssi", $full_name, $phone, $uid);
        if ($stmt->execute()) {
            // Update session cache if used elsewhere
            $_SESSION['user_name'] = $full_name;
            $_SESSION['flash_success'] = 'Profile updated successfully.'; 
        } else {
            $_SESSION['flash_error'] = 'Failed to save changes.';
        }
        $stmt->close();
    } else {
        $_SESSION['flash_error'] = 'Failed to save changes.';
    }
    header('Location: account.php?tab=profile'); // Redirect back to the profile tab after saving
    exit;
}
// Simple helper to show one-time alerts (success/error)
function flash($key){
    if (!empty($_SESSION[$key])) {
        $msg = $_SESSION[$key];
        unset($_SESSION[$key]);
        return '<div class="container" style="margin-top:15px;"><div style="padding:12px 16px;border-radius:6px;background:#fff3cd;border:1px solid #ffeeba;color:#856404;">'.htmlspecialchars($msg).'</div></div>';
    }
    return '';
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $user_logged_in = false;
} else {
    $user_logged_in = true;
    // Fetch user data
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}

// --- Auth context ---
$logged_in  = isset($_SESSION['user_id']);
$user_id    = $logged_in ? (int)$_SESSION['user_id'] : 0;
$user_name  = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest';
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '';

// --- Determine active tab from query (?tab=...) ---
$valid_tabs = ['bookings','perks','settings','profile','reservations'];
$active_tab = isset($_GET['tab']) && in_array($_GET['tab'], $valid_tabs) ? $_GET['tab'] : 'bookings';

// --- Bookings (single table, newest first) ---
$bookings = [];
if ($logged_in) {
    $sql = "SELECT 
                o.id          AS order_id,
                o.created_at  AS order_time,
                o.total_price AS order_total,
                o.status      AS order_status,
                s.name        AS show_name,
                s.venue       AS venue,
                s.date        AS show_datetime,
                oi.quantity   AS qty,
                oi.price      AS price_each,
                oi.show_time  AS show_time
            FROM orders o
            JOIN order_items oi ON oi.order_id = o.id
            JOIN shows s        ON s.id = oi.show_id
            WHERE o.user_id = ?
            ORDER BY o.created_at DESC, s.date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $bookings[] = $row;
    }
    $stmt->close();
}
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Account</title>
  <link rel="stylesheet" href="styles.css">

</head>
<body>
<header>
  <div class="nav-container">
    <div class="logo-container">
      <img src="logos.png" alt="Sydney Opera House" class="logo">
    </div>
    <ul class="nav-menu">
      <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
      <li class="nav-item"><a href="shows.php" class="nav-link">Shows</a></li>
      <li class="nav-item">
        <a href="carts.php" class="nav-link">
          Cart <span class="cart-badge" id="cartBadge">0</span>
        </a>
      </li>
      <li class="nav-item"><a href="experiences.php" class="nav-link">Experiences</a></li>
      <li class="nav-item"><a href="account.php" class="nav-link active">Account</a></li>
      <?php if ($logged_in): ?>
        <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>
      <?php else: ?>
        <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
      <?php endif; ?>
    </ul>
  </div>
</header>

<?php
echo flash('flash_error');
echo flash('flash_success');
?>

<?php if (!$logged_in): ?>
  <!-- Not logged in prompt -->
  <section class="account-prompt">
    <i class="fas fa-user-circle profile-icon" aria-hidden="true"></i>
    <h2 class="account-title">My Account</h2>
    <p class="login-message">Please log in to view your bookings, membership perks, profile, and settings.</p>
    <a href="account.html" class="btn login-launch-btn">Login / Register</a>
  </section>
<?php else: ?>
  <section class="account-dashboard">
    <div class="dashboard-grid">
      <!-- Sidebar -->
      <aside class="sidebar-nav">
        <ul class="nav-list">
        <li class="nav-item-link <?php echo $active_tab==='profile' ? 'active' : ''; ?>">
            <a href="account.php?tab=profile"><i class="fas fa-user"></i> Profile</a>
          </li>  
        <li class="nav-item-link <?php echo $active_tab==='bookings' ? 'active' : ''; ?>">
            <a href="account.php?tab=bookings"><i class="fas fa-ticket-alt"></i> My Bookings</a>
          </li>
          <li class="nav-item-link <?php echo $active_tab==='reservations' ? 'active' : ''; ?>">
            <a href="account.php?tab=reservations"><i class="fas fa-calendar-check"></i> Reservations</a>
          </li>
          <li class="nav-item-link <?php echo $active_tab==='perks' ? 'active' : ''; ?>">
            <a href="account.php?tab=perks"><i class="fas fa-gift"></i> Membership Perks</a>
          </li>
          <li class="nav-item-link <?php echo $active_tab==='settings' ? 'active' : ''; ?>">
            <a href="account.php?tab=settings"><i class="fas fa-cog"></i> Settings</a>
          </li>
          
          <li class="nav-item-link">
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
          </li>
        </ul>
      </aside>

      <!-- Main content -->
      <main class="main-content-area">
        <h3 class="content-heading">Welcome, </h3>

        
        <!-- Reservations tab -->
        <div class="account-tab-content <?php echo $active_tab==='reservations' ? 'active' : ''; ?>" id="tab-reservations">
          <div class="booking-status-header upcoming-header">My Reservations</div>
          <?php
            $user_email = isset($user['email']) ? $user['email'] : (isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '');
            $res_rows = [];
            if ($logged_in && $user_email) {
                if ($stmt = $conn->prepare("SELECT id, full_name, email, phone, date, time, guests, notes, created_at FROM reservations WHERE email = ? ORDER BY created_at DESC")) {
                    $stmt->bind_param("s", $user_email);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($r = $result->fetch_assoc()) { $res_rows[] = $r; }
                    $stmt->close();
                }
            }
          ?>
          <table class="booking-table" aria-label="My Reservations">
            <thead>
              <tr>
                <th>#</th>
                <th>Submitted</th>
                <th>Date</th>
                <th>Time</th>
                <th>Guests</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Notes</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($res_rows)): ?>
                <tr><td colspan="8" class="empty-message">No reservations found for your account.</td></tr>
              <?php else: foreach ($res_rows as $row): ?> // Otherwise, loop through each booking record and display it
                <tr>
                  <td><?php echo (int)$row['id']; ?></td>
                  <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                  <td><?php echo htmlspecialchars($row['date']); ?></td>
                  <td><?php echo htmlspecialchars(substr($row['time'],0,5)); ?></td>
                  <td><?php echo (int)$row['guests']; ?></td>
                  <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                  <td><?php echo htmlspecialchars($row['phone']); ?></td>
                  <td><?php echo htmlspecialchars($row['notes']); ?></td>
                </tr>
              <?php endforeach; endif; ?>
            </tbody>
          </table>
        </div>

<!-- Bookings tab -->
        <div class="account-tab-content <?php echo $active_tab==='bookings' ? 'active' : ''; ?>" id="tab-bookings">
          


          <div class="booking-status-header upcoming-header">My Bookings</div>
          <table class="booking-table" aria-label="My Bookings">
            <thead>
              <tr>
                <th>Order #</th>
                <th>Booked On</th>
                <th>Show</th>
                <th>Venue</th>
                <th>Show Date &amp; Time</th>
                <th>Qty</th>
                <th>Price (each)</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if (count($bookings) === 0): ?> <!-- Check if the user has any bookings stored in $bookings -->
                <tr><td colspan="8" class="empty-message">No bookings yet.</td></tr>
              <?php else: foreach ($bookings as $b): ?> <!-- Otherwise, loop through each booking record and display it -->
                <tr>
                  <td>#<?php echo (int)$b['order_id']; ?></td>
                  <td><?php echo htmlspecialchars(date('M j, Y g:i A', strtotime($b['order_time']))); ?></td>
                  <td><?php echo htmlspecialchars($b['show_name']); ?></td>
                  <td><?php echo htmlspecialchars($b['venue']); ?></td>
                  <td><?php echo htmlspecialchars($b['show_time'] ?? ''); ?></td>
                  <td><?php echo (int)$b['qty']; ?></td>
                  <td>$<?php echo number_format((float)$b['price_each'], 2); ?></td>
                  <td><?php echo htmlspecialchars($b['order_status']); ?></td>
                </tr>
              <?php endforeach; endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Membership Perks tab -->
        <div class="account-tab-content <?php echo $active_tab==='perks' ? 'active' : ''; ?>" id="tab-perks">
          <div class="booking-status-header past-header">Membership Perks</div>
          <div class="perks-grid">
            
            <div class="perk-card">
              <h4>Member Discounts</h4>
              <p>Save up to 10% on all performances and experiences.</p>
            </div>
            <div class="perk-card">
              <h4>Lounge Access</h4>
              <p>Enjoy pre-show lounge access on selected nights.</p>
            </div>
            
          </div>
        </div>

        <!-- Settings tab with working Change Password form -->
        <div class="account-tab-content <?php echo $active_tab==='settings' ? 'active' : ''; ?>" id="tab-settings">
          <div class="booking-status-header past-header">Settings</div>
          <p>Update your password below.</p>
          <form action="change_password.php" method="POST" class="profile-form" style="max-width:520px;margin-top:15px;">
            <div class="form-group">
              <label for="current_password">Current Password</label>
              <input type="password" id="current_password" name="current_password" required>
            </div>
            <div class="form-group">
              <label for="new_password">New Password</label>
              <input type="password" id="new_password" name="new_password" minlength="6" required>
            </div>
            <div class="form-group">
              <label for="confirm_password">Confirm New Password</label>
              <input type="password" id="confirm_password" name="confirm_password" minlength="6" required>
            </div>
            <button type="submit" class="btn">Change Password</button>
          </form>
          <p style="margin-top:15px;">Or <a href="logout.php">log out</a>.</p>
        </div>

        <!-- Profile tab -->
        <div class="account-tab-content <?php echo $active_tab==='profile' ? 'active' : ''; ?>" id="tab-profile">
                        <h3 class="content-heading">My Profile</h3>
                        
                        <div class="profile-header-card">
                            <i class="fas fa-user-circle profile-avatar-lg"></i>
                            <div class="user-details">
                                <h4 id="profileName"><?php echo htmlspecialchars($user['full_name']); ?></h4>
                                <p id="profileEmail"><?php echo htmlspecialchars($user['email']); ?></p>
                            </div>
                        </div>
                        
                        
                        <form class="profile-form" method="post" action="account.php?tab=profile" novalidate>
                            <input type="hidden" name="_profile_update" value="1">
                            <h4 class="form-section-title">Update Personal Details</h4>
                            <div class="form-group">
                                <label for="fullName">Full Name</label>
                                <input type="text" id="fullName" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="emailInput">Email</label>
                                <input type="email" id="emailInput" value="<?php echo htmlspecialchars($user['email']); ?>" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="phoneInput">Phone</label>
                                <input type="tel" id="phoneInput" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" class="form-control" placeholder="+61 XXX XXX XXX">
                            </div>
                            <button type="submit" class="btn primary-btn">Save Changes</button>
                        </form>
        
                    </div>




        </div>
      </main>
    </div>
  </section>
<?php endif; ?>

<footer>
  <div class="footer-content">
    <div class="footer-column">
      <h3>Sydney Opera House</h3>
      <p>Bennelong Point<br>Sydney NSW 2000<br>Australia</p>
    </div>
    <div class="footer-column">
      <h3>Quick Links</h3>
      <ul class="footer-links">
        <li><a href="shows.php">What's On</a></li>
        <li><a href="account.php">My Account</a></li>
      </ul>
    </div>
  </div>
</footer>

<script src="cart-store.js"></script>
<script src="cart-badge.js"></script>
<script>
// Clear cart if flagged by checkout
<?php if (!empty($_SESSION['clear_cart'])): unset($_SESSION['clear_cart']); ?>
try { localStorage.removeItem('cart'); } catch(_) {}
<?php endif; ?>
</script>
</body>
</html>