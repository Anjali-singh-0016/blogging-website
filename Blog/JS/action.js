const backgrounds = [
    'assests/bg-1.jpg',
    'assests/bg-2.jpg',
    'assests/bg-3.jpg',
    'assests/bg-4.jpg',
    'assests/bg-5.jpg',
    'assests/bg-6.jpg'
];

let currentIndex = 0;

// Preload images to avoid delays during transitions
backgrounds.forEach(image => {
    const img = new Image();
    img.src = image;
});

function changeBackground() {
    const backgroundContainer = document.querySelector('.background-container');

    // Update the background image
    backgroundContainer.style.backgroundImage = `url(${backgrounds[currentIndex]})`;

    // Move to the next image index
    currentIndex = (currentIndex + 1) % backgrounds.length;
}

// Set an interval to update the background after each animation cycle
setInterval(changeBackground, 10000); // Matches the animation duration

// Initialize the first background
changeBackground();

document.addEventListener('DOMContentLoaded', () => {
    const googleLoginButton = document.getElementById('googleLogin');
    const googleSignupButton = document.getElementById('googleSignup');

    // Initialize Google OAuth
    google.accounts.id.initialize({
        client_id: 'YOUR_GOOGLE_CLIENT_ID',
        callback: handleCredentialResponse,
    });

    // Add Google Login Button
    google.accounts.id.renderButton(googleLoginButton, {
        theme: 'outline',
        size: 'large',
    });

    // Add Google Sign-Up Button
    google.accounts.id.renderButton(googleSignupButton, {
        theme: 'outline',
        size: 'large',
    });

    // Handle Google OAuth Response
    function handleCredentialResponse(response) {
        const jwt = response.credential;
        console.log('Google ID Token:', jwt);
        // Send this JWT to your server for verification and login/signup logic
    }

    // Form Validation
    function showNotification(message, type) {
        const notification = document.getElementById('notification');
        notification.innerText = message;
        notification.className = `notification ${type}`;
        notification.style.display = 'block';

        // Hide notification after 3 seconds
        setTimeout(() => {
            notification.style.display = 'none';
        }, 3000);
    }

    const loginForm = document.getElementById('loginForm');
    const signupForm = document.getElementById('signupForm');

    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const email = loginForm.email.value.trim();
            const password = loginForm.password.value.trim();

            if (!email || !password) {
                alert('Please fill all fields.');
                return;
            }

            const formData = new FormData(loginForm); // Correct use of the form

            fetch('process_login.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        showNotification(data.message, 'success');
                        window.location.href = data.redirect; // Redirect on success
                    } else {
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    showNotification('An error occurred. Please try again.', 'error');
                    console.error('Error:', error);
                });
        });
    }

    if (signupForm) {
        signupForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const name = signupForm.name.value.trim();
            const email = signupForm.email.value.trim();
            const password = signupForm.password.value.trim();
            const confirmPassword = signupForm.confirmPassword.value.trim();

            if (!name || !email || !password || !confirmPassword) {
                alert('Please fill all fields.');
                return;
            }

            if (password !== confirmPassword) {
                alert('Passwords do not match.');
                return;
            }

            const formData = new FormData(signupForm); // Correct use of the form

            fetch('process_signup.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        showNotification(data.message, 'success'); // Show success message
                        window.location.href = data.redirect; // Redirect on success
                    } else {
                        showNotification(data.message, 'error') // Show error message
                    }
                })
                .catch(error => {
                    showNotification('An error occurred. Please try again.', 'error');
                    console.error('Error:', error);
                });
        });
    }
});
