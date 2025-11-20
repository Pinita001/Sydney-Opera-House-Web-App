<?php
session_start();
include('db.php'); // Includes your database connection file so you can run SQL queries below

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // If the user is NOT logged in, redirect them to the login page
    exit(); 
}

// This runs only when the URL includes a query parameter like cart.php?add_to_cart=3
// meaning the user clicked an "Add to Cart" button for show ID #3.
if (isset($_GET['add_to_cart'])) { 
    $show_id = $_GET['add_to_cart']; 
    $user_id = $_SESSION['user_id'];

    // Check if item is already in the cart
    $sql = "SELECT * FROM cart_items WHERE user_id = ? AND show_id = ?";
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param("ii", $user_id, $show_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Insert the item into the cart
        $sql = "INSERT INTO cart_items (user_id, show_id, quantity) VALUES (?, ?, 1)"; // Prepare an SQL INSERT command to add the show to the cart
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $show_id); // Bind both user_id and show_id into the query (both are integers)
        $stmt->execute(); 
    }
}

// ================= FETCH ALL CART ITEMS =================
$user_id = $_SESSION['user_id'];
$sql = "SELECT cart_items.*, shows.name, shows.price FROM cart_items JOIN shows ON cart_items.show_id = shows.id WHERE cart_items.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!-- ==============================================
       DISPLAY THE CART CONTENTS AS AN HTML TABLE
     ============================================== -->
<h2>Your Cart</h2>
<table>
    <tr>
        <th>Show</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Remove</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?> <!-- PHP loop: runs once per cart item -->
    <tr>
        <td><?php echo $row['name']; ?></td>
        <td>$<?php echo $row['price']; ?></td>
        <td><?php echo $row['quantity']; ?></td>
        <td><a href="cart.php?remove=<?php echo $row['show_id']; ?>">Remove</a></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php
// Remove item from cart
if (isset($_GET['remove'])) {
    $show_id = $_GET['remove'];

    // Delete the item from the cart
    $sql = "DELETE FROM cart_items WHERE user_id = ? AND show_id = ?"; // SQL command to delete the specific item from the current user's cart
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $show_id);
    $stmt->execute();
    header("Location: cart.php"); // Redirects back to cart.php to refresh the page and show the updated cart
}

// Checkout button, LINK
echo '<a href="checkout.php">Proceed to Checkout</a>';
?>

