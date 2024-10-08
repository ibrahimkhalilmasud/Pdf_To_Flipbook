// return_homepage.js

document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scrolling to all links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Add hover effect to flipbook cards
    const flipbookCards = document.querySelectorAll('.flipbook-card');
    flipbookCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.boxShadow = 'none';
        });
    });

    // Add a welcome message
    const welcomeMessage = document.createElement('div');
    welcomeMessage.textContent = 'Welcome back to Heyzine!';
    welcomeMessage.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #26ae61;
        color: white;
        padding: 10px 20px;
        border-radius: 4px;
        opacity: 0;
        transition: opacity 0.5s ease;
    `;
    document.body.appendChild(welcomeMessage);

    setTimeout(() => {
        welcomeMessage.style.opacity = '1';
    }, 500);

    setTimeout(() => {
        welcomeMessage.style.opacity = '0';
    }, 3000);
});