// Reads the cart data from localStorage and updates the count badge in the header.
function updateCartBadge() {
    const cartBadge = document.getElementById('cartBadge'); // select the badge element in the header
    
    if (!cartBadge) return; // exit if no badge element is found (avoids script errors on pages without cart badge)

    try {
        const cart = readCartArr();
        
        // Calculate the total number of items (tickets quantity)
        const totalItems = cart.reduce((total, item) => total + parseInt(item.quantity || 0), 0);   // We use 'quantity' from the cart item object
        
        cartBadge.textContent = totalItems; // display the total quantity as text on the badge
        
        cartBadge.style.display = totalItems > 0 ? 'inline-block' : 'none';  // Show badge if count > 0, otherwise hide

    } catch (e) {
        console.error("Error reading or parsing cart data from localStorage:", e);
        cartBadge.textContent = '0';
        cartBadge.style.display = 'none';
    }
}

// Ensures correct cart count appears as soon as the user navigates to any page.
document.addEventListener('DOMContentLoaded', updateCartBadge);

// Auto-update badge on page load and whenever the cart changes (same tab or other tabs).
window.addEventListener('DOMContentLoaded', function(){ try { updateCartBadge(); } catch(e) {} });  // recheck badge after DOM is loaded
window.addEventListener('cart:changed', function(){ try { updateCartBadge(); } catch(e) {} });  // recheck badge when custom 'cart:changed' event fires
window.addEventListener('storage', function(ev){ if (ev && ev.key === 'cart_str') { try { updateCartBadge(); } catch(e) {} } });    // only respond to cart updates in localStorage
