// Function to toggle the expanded details section of a show card
function toggleShowDetails(targetId) {
    const targetElement = document.getElementById(targetId); // find <details> by its ID
    if (targetElement) {
        // Find the show card parent
        const showCard = targetElement.closest('.show-card'); 
        
        // toggle logic 
        if (targetElement.style.display === 'block') {
            // If it's currently open, hide it
            targetElement.style.display = 'none';
        } else {
            // Before opening this one, close all others
            document.querySelectorAll('.show-details-expanded').forEach(detail => {
                if (detail.id !== targetId) {
                    detail.style.display = 'none';
                }
            });

            // Show the selected one
            targetElement.style.display = 'block';
            
            // Smoothly scroll to that card so user sees it open
            showCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
}

// Function to handle the Add to Cart process
function setupAddToCart() {
    const quantityModal = document.getElementById('quantityModal');
    const confirmAddToCartBtn = document.getElementById('confirmAddToCartBtn');
    const closeQuantityModal = document.getElementById('closeQuantityModal');
    
    let currentShowDetails = {}; // Stores details of the show currently being booked

    // Add event listeners for every "Add to Cart" button
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function() { 
            const showName = this.getAttribute('data-show'); // Get the show name and showtime from this button’s custom attributes
            const showTime = this.getAttribute('data-time');
            
            // Store details globally for the confirmation step
            currentShowDetails = { showName, showTime };

            document.getElementById('modalShowName').textContent = showName; // Show the name and time inside the popup window
            document.getElementById('modalShowTime').textContent = showTime;
            document.getElementById('ticketQuantity').value = 1; // Set the quantity input inside the modal back to 1 each time
            quantityModal.classList.add('active'); // Show the modal (by adding an .active class)
        });
    });

    // Modal close button logic
    closeQuantityModal.addEventListener('click', () => {
        quantityModal.classList.remove('active');
    });

    // When user confirms "Add to Cart" inside modal
    confirmAddToCartBtn.addEventListener('click', () => {
        const quantity = parseInt(document.getElementById('ticketQuantity').value);
        
        // Validation: must be positive integer
        if (quantity < 1) {
            alert("Please select a valid quantity.");
            return;
        }
        // Create an object representing one booking item
        const cartItem = {
            showName: currentShowDetails.showName,
            showtime: currentShowDetails.showTime,
            quantity: quantity,
            price: 150.00 // hardcoded default; can be replaced by real price
        };

        // Save to localStorage
        let cart = readCartArr();
        cart.push(cartItem);
        writeCartArr(cart);
        
        // Update the cart badge (number in navbar)
        if (typeof updateCartBadge === 'function') {
            updateCartBadge();
        }
        
        // Notify user and close the modal
        alert(`Added ${quantity} ticket(s) for ${currentShowDetails.showName} at ${currentShowDetails.showTime} to your cart!`);
        quantityModal.classList.remove('active');
    });
}


// --- Main Execution. Runs once the page has loaded ---
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Make all the “More Details” buttons work
    // Each button opens or closes the extra show info (description)
    document.querySelectorAll('.details-btn').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target'); // Get the ID of the details section this button controls (like "details-3")
            toggleShowDetails(targetId); // Open or close that show’s details box
        }); 
    });
    
    // 2. Check if the page link has something like ?open=1 in the URL
    // (this happens when user clicks “Book Tickets” from the homepage)
    const urlParams = new URLSearchParams(window.location.search);
    const openShowId = urlParams.get('open'); // Gets the '1', '2', or '3' from the URL
    
    if (openShowId) {
        // Automatically open the details section if an ID is present in the URL
        const targetId = `details-${openShowId}`;
        toggleShowDetails(targetId);
    }
    
    // 3. Set up Add to Cart functionality using the modal
    setupAddToCart();
});