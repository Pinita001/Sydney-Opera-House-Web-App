// Handles the display and interaction of the login/register modal, including tab switching and modal open/close behavior.
document.addEventListener('DOMContentLoaded', function () { // wait for DOM to fully load before running any script logic
    
    const modal = document.getElementById('loginRegisterModal'); // main modal container
    const loginModalBtn = document.getElementById('loginModalBtn'); // button that opens the modal
    const closeModal = document.getElementById('closeModal'); // button that closes the modal
    
    // Tabs
    const loginTabBtn = document.getElementById('loginTabBtn'); // tab button for login
    const registerTabBtn = document.getElementById('registerTabBtn'); // tab button for register
    const loginFormContainer = document.getElementById('loginFormContainer'); // form container for login form
    const registerFormContainer = document.getElementById('registerFormContainer'); // form container for register form

    //  Function to toggle between login and register tabs. It deactivates all forms and activates the selected one.
    function openTab(tabName) {
        // Deactivate all forms/tabs
        if (loginTabBtn) loginTabBtn.classList.remove('active'); // remove active highlight from login tab
        if (registerTabBtn) registerTabBtn.classList.remove('active'); // remove active highlight from register tab
        if (loginFormContainer) loginFormContainer.classList.remove('active'); // hide login form
        if (registerFormContainer) registerFormContainer.classList.remove('active'); // hide register form

        // Activate the selected tab/form
        if (tabName === 'login' && loginTabBtn && loginFormContainer) {
            loginTabBtn.classList.add('active'); // highlight login tab
            loginFormContainer.classList.add('active'); // display login form
        } else if (tabName === 'register' && registerTabBtn && registerFormContainer) {
            registerTabBtn.classList.add('active'); // highlight register tab
            registerFormContainer.classList.add('active'); // display register form
        }
    }

    // Event Listeners for Tab Switching
    if (loginTabBtn) {
        loginTabBtn.addEventListener('click', () => openTab('login')); // switch to login form when clicked
    }
    if (registerTabBtn) {
        registerTabBtn.addEventListener('click', () => openTab('register')); // switch to register form when clicked
    }

    // Open modal when the launcher button is clicked
    if (loginModalBtn && modal) {
        loginModalBtn.addEventListener('click', function () {
            modal.classList.add('active'); // show modal by adding active class
            openTab('login'); // ensure login tab appears first when modal opens
        });
    }
    
    // Close modal when the close button is clicked
    if (closeModal && modal) {
        closeModal.addEventListener('click', function () {
            modal.classList.remove('active'); // hide modal when close button clicked
        });
        
        // Close modal if clicked outside of the modal content
        modal.addEventListener('click', function (e) {
            if (e.target === modal) { // if the background (not modal content) is clicked
                modal.classList.remove('active'); // hide modal
            }
        });
    }

    // This ensures the red highlight (login tab) is active immediately on page load.
    if (loginTabBtn) {
        openTab('login'); // default tab on load is login
    }
});
