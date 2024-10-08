document.addEventListener('DOMContentLoaded', function() {
    // Form submission handling
    const supportForm = document.querySelector('form');
    if (supportForm) {
        supportForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const subject = document.getElementById('subject').value.trim();
            const message = document.getElementById('message').value.trim();
            
            if (subject === '' || message === '') {
                alert('Please fill in both the subject and message fields.');
                return;
            }
            
            // If validation passes, submit the form
            this.submit();
        });
    }

    // Character count for message textarea
    const messageTextarea = document.getElementById('message');
    const charCount = document.createElement('div');
    charCount.className = 'char-count';
    if (messageTextarea) {
        messageTextarea.parentNode.insertBefore(charCount, messageTextarea.nextSibling);
        
        function updateCharCount() {
            const remaining = 1000 - messageTextarea.value.length;
            charCount.textContent = `${remaining} characters remaining`;
            if (remaining < 100) {
                charCount.style.color = 'red';
            } else {
                charCount.style.color = 'inherit';
            }
        }
        
        messageTextarea.addEventListener('input', updateCharCount);
        updateCharCount(); // Initial count
    }

    // Expandable ticket items
    const ticketItems = document.querySelectorAll('.ticket-item');
    ticketItems.forEach(item => {
        const heading = item.querySelector('h3');
        const content = item.querySelector('.ticket-message');
        
        if (heading && content) {
            content.style.display = 'none'; // Initially hide content
            
            heading.addEventListener('click', () => {
                content.style.display = content.style.display === 'none' ? 'block' : 'none';
            });
            
            heading.style.cursor = 'pointer';
        }
    });
});