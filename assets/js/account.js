// account.js

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const newPasswordInput = document.getElementById('new_password');
    const confirmPasswordInput = document.getElementById('confirm_password');

    form.addEventListener('submit', function(e) {
        if (newPasswordInput.value !== confirmPasswordInput.value) {
            e.preventDefault();
            alert('New password and confirm password do not match.');
        }
    });

    // Add password strength meter
    newPasswordInput.addEventListener('input', function() {
        const strength = calculatePasswordStrength(this.value);
        updatePasswordStrengthMeter(strength);
    });

    function calculatePasswordStrength(password) {
        let strength = 0;
        if (password.length >= 8) strength++;
        if (password.match(/[a-z]+/)) strength++;
        if (password.match(/[A-Z]+/)) strength++;
        if (password.match(/[0-9]+/)) strength++;
        if (password.match(/[$@#&!]+/)) strength++;
        return strength;
    }

    function updatePasswordStrengthMeter(strength) {
        const meter = document.getElementById('password-strength-meter');
        const text = document.getElementById('password-strength-text');

        meter.value = strength;

        switch(strength) {
            case 0:
            case 1:
                text.textContent = 'Weak';
                text.style.color = 'red';
                break;
            case 2:
            case 3:
                text.textContent = 'Medium';
                text.style.color = 'orange';
                break;
            case 4:
            case 5:
                text.textContent = 'Strong';
                text.style.color = 'green';
                break;
        }
    }

    // Add show/hide password functionality
    const togglePasswordButtons = document.querySelectorAll('.toggle-password');
    togglePasswordButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.textContent = type === 'password' ? 'Show' : 'Hide';
        });
    });
});