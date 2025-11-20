// Run this code after the page has fully loaded
document.addEventListener('DOMContentLoaded', function() {
     // 1. Check if the page URL has a parameter like ?open=1
    const urlParams = new URLSearchParams(window.location.search);
    const openShowId = urlParams.get('open');
    
    if (openShowId) {
        // Build the ID for the matching <details> tag (e.g., "details-1")
        const detailsElementId = `details-${openShowId}`;
        const targetDetails = document.getElementById(detailsElementId);
        
        if (targetDetails) {
            // 2. Automatically open the <details> tag
            targetDetails.setAttribute('open', '');
            
            // 3. Find the full show card that contains this <details>
            // (.closest climbs up the HTML to the nearest .show-card parent)
            const showCard = targetDetails.closest('.show-card');
            
            if (showCard) {
                
                showCard.classList.add('linked-show-highlight'); // Highlight the card
                
                showCard.scrollIntoView({ behavior: 'smooth', block: 'center' }); // Smoothly scroll to that card in the middle of the screen
                
                // Remove the highlight after 4 seconds for a dynamic effect
                setTimeout(() => {
                    showCard.classList.remove('linked-show-highlight'); 
                }, 4000); // Highlight lasts for 4 seconds
            }
        }
    }
});