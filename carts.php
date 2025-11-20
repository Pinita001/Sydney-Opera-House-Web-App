<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Sydney Opera House</title>
    <link rel="stylesheet" href="styles.css">

</head>
    <!-- =================== FLASH MESSAGE (AFTER CHECKOUT SUCCESS) =================== -->
    <?php if (!empty($_SESSION['guest_flash_success'])): ?>
    <!-- Shows a yellow info box if a temporary success message is stored in the session -->
    <div style="max-width:1200px;margin:20px auto;padding:18px 20px;background:#fff3cd;border:1px solid #ffeeba;border-radius:8px;color:#856404;font-size:1rem;">
        // Display and then remove the flash message to prevent it showing again
        <?php echo htmlspecialchars($_SESSION['guest_flash_success']); unset($_SESSION['guest_flash_success']); ?>
    </div>
    <?php endif; ?>
    
    <header>
        <div class="nav-container">
            <div class="logo-container">
                <img src="logos.png" alt="Sydney Opera House" class="logo">
            </div>
            <ul class="nav-menu">
                <li class="nav-item"><a href="index.php" class="nav-link" data-page="home">Home</a></li>
                <li class="nav-item"><a href="shows.php" class="nav-link" data-page="shows">Shows</a></li>
                <li class="nav-item">
                    <a href="carts.php" class="nav-link" data-page="cart">
                        Cart
                        <span class="cart-badge" id="cartBadge">0</span>
                    </a>
                </li>
                <li class="nav-item"><a href="experiences.php" class="nav-link" data-page="experiences">Experiences</a></li>
                <li class="nav-item"><a href="account.php" class="nav-link" data-page="account">Account</a></li>
                <li class="nav-item">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="logout.php" class="nav-link" id="logoutLink">Logout</a>
                    <?php else: ?>
                        <a href="account.php" class="nav-link" id="headerLoginLink">Login</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </header>

    <section class="cart-container">
        <div class="container">
            <h2 class="section-title">Your <span>Cart</span></h2>
            
            <table class="cart-table" id="cartTable">
                <thead>
                    <tr>
                        <th>Show</th>
                        <th>Showtime</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody id="cart-items-body">
                    </tbody>
            </table>

            <div class="cart-summary">
                <div class="summary-line">
                    <span>Total Items:</span>
                    <span id="totalItems">0</span>
                </div>
                <!-- Hidden by default; shown only for logged-in users -->
                <div id="memberDiscountRow" class="summary-line" style="display:none;">
    <span>Member Discount (10%):</span>
    <span id="memberDiscountAmount">-$0.00</span>
</div>
<div class="summary-line total-price-line">
                    <strong>Estimated Total:</strong>
                    <strong id="cartTotal">$0.00</strong>
                </div>
                <!-- Checkout button (disabled until cart is not empty) -->
                <button class="btn primary-btn checkout-btn" id="checkoutBtn" disabled>Proceed to Checkout</button>
            </div>
            
        </div>
    </section>

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
        let cart = readCartArr(); // Load saved cart data from browser storage

        var IS_LOGGED_IN = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>; // PHP-injected login flag for member discount
        
        // Get references to key elements for updating
        const cartBody = document.getElementById('cart-items-body');
        const cartTotalDisplay = document.getElementById('cartTotal');
        const totalItemsDisplay = document.getElementById('totalItems');
        const checkoutBtn = document.getElementById('checkoutBtn');
        let grandTotal = 0; // Sum of all item prices
        let totalQuantity = 0; // Total number of tickets

        function renderCart() { // Clear any existing rows before re-building
            cartBody.innerHTML = '';
            grandTotal = 0;
            totalQuantity = 0;

            // If cart is empty, show a message and reset totals
            if (cart.length === 0) {
                cartBody.innerHTML = '<tr><td colspan="6" class="empty-cart-message">Your cart is empty. <a href="shows.php">Go shopping!</a></td></tr>';
                
                // Set totals to zero when the cart is empty
                cartTotalDisplay.textContent = '$0.00';
                totalItemsDisplay.textContent = '0';
                var r=document.getElementById('memberDiscountRow'); if(r){r.style.display='none';} // Hide discount row
                checkoutBtn.disabled = true;
                return;
            }

            // Loop through each item in the cart array
            cart.forEach((item, index) => {
                const subtotal = item.price * item.quantity; // Compute subtotal
                grandTotal += subtotal; // Add to running total
                totalQuantity += item.quantity;

                const row = document.createElement('tr'); // Create new table row for this item
                row.setAttribute('data-index', index); // Save index for editing/removing later2
                 
                // Build row HTML using template literals
                row.innerHTML = `
                    <td>${item.showName}</td>
                    <td>${item.showtime}</td>
                    <td>$${item.price.toFixed(2)}</td>
                    <td>
                        <input type="number" class="quantity-input" value="${item.quantity}" min="1" max="10">
                    </td>
                    <td>$${subtotal.toFixed(2)}</td>
                    <td><button class="btn remove-btn" data-index="${index}">🗑️</button></td>
                `;
                cartBody.appendChild(row); // Add row to table
            });

            // Compute member discount if logged in
            var discount = IS_LOGGED_IN ? (grandTotal * 0.10) : 0;
            var totalAfterDiscount = grandTotal - discount;
            // Update discount row visibility and amount
            var discountRow = document.getElementById('memberDiscountRow');
            var discountAmt = document.getElementById('memberDiscountAmount');
            if (discountRow && discountAmt) {
                if (IS_LOGGED_IN && grandTotal > 0) {
                    discountRow.style.display = 'flex';
                    discountAmt.textContent = `-$${discount.toFixed(2)}`;
                } else {
                    discountRow.style.display = 'none';
                    discountAmt.textContent = '-$0.00';
                }
            }

            // ------------------- UPDATE TOTALS -------------------
            cartTotalDisplay.textContent = `$${totalAfterDiscount.toFixed(2)}`;
            totalItemsDisplay.textContent = totalQuantity;
            checkoutBtn.disabled = false;
        }

        // ------------------- HANDLE QUANTITY CHANGES -------------------
        document.addEventListener('DOMContentLoaded', renderCart);

        // Event delegation for quantity change
        cartBody.addEventListener('change', function(e) {
            if (e.target.classList.contains('quantity-input')) {
                const input = e.target; // The <input> box that changed
                const newQuantity = parseInt(input.value);
                const index = input.closest('tr').getAttribute('data-index'); // Find item index

                if (newQuantity < 1 || isNaN(newQuantity)) {
                    input.value = cart[index].quantity; // Revert to previous value
                    alert("Quantity must be at least 1.");
                    return;
                }
                
                // Save new quantity and re-render the cart
                cart[index].quantity = newQuantity;
                writeCartArr(cart);
                renderCart(); // Re-render to update subtotals and totals
                if (typeof updateCartBadge === 'function') {
                    updateCartBadge(); // Update badge safely
                }
            }
        });

        // ------------------- HANDLE ITEM REMOVAL -------------------
        cartBody.addEventListener('click', function(e) {
            if (e.target.closest('.remove-btn')) {
                const button = e.target.closest('.remove-btn');
                const index = parseInt(button.getAttribute('data-index')); // Which item to delete

                // Remove item from cart and update localStorage
                cart.splice(index, 1);
                writeCartArr(cart);
                
                // Update the cart badge right away
                if (typeof updateCartBadge === 'function') {
                    updateCartBadge();
                }

                renderCart(); // Re-render the cart table and update totals
            }
        });

        // ------------------- CHECKOUT REDIRECT -------------------
        document.getElementById('checkoutBtn').onclick = function() {
            if (cart.length > 0) {
                window.location.href = 'checkouts.html'; // Redirect to the checkout page
            }
        };
    </script></body>
</html>