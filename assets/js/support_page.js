// js/support_page.js
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const supportForm = document.querySelector('form');
    supportForm.addEventListener('submit', function(event) {
        const subject = document.getElementById('subject').value.trim();
        const message = document.getElementById('message').value.trim();
        
        if (subject === '' || message === '') {
            event.preventDefault();
            alert('Please fill out all fields before submitting.');
        }
    });

    // Character count for message
    const messageTextarea = document.getElementById('message');
    const charCount = document.createElement('div');
    charCount.className = 'char-count';
    messageTextarea.parentNode.insertBefore(charCount, messageTextarea.nextSibling);

    messageTextarea.addEventListener('input', function() {
        const remaining = 1000 - this.value.length;
        charCount.textContent = `${remaining} characters remaining`;
        
        if (remaining < 0) {
            charCount.style.color = 'red';
        } else {
            charCount.style.color = 'inherit';
        }
    });

    // Ticket list toggle
    const ticketItems = document.querySelectorAll('.ticket-item');
    ticketItems.forEach(item => {
        const heading = item.querySelector('h3');
        const message = item.querySelector('.ticket-message');
        
        heading.addEventListener('click', () => {
            message.style.display = message.style.display === 'none' ? 'block' : 'none';
        });
        
        // Initially hide the message
        message.style.display = 'none';
    });
});