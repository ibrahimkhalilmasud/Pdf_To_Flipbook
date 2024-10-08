// stats.js

document.addEventListener('DOMContentLoaded', function() {
    // Animate stat numbers
    const statNumbers = document.querySelectorAll('.stat-number');
    statNumbers.forEach(number => {
        const finalValue = parseInt(number.textContent);
        animateValue(number, 0, finalValue, 2000);
    });

    // Create chart
    createChart();
});

function animateValue(obj, start, end, duration) {
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        obj.innerHTML = Math.floor(progress * (end - start) + start);
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}

function createChart() {
    const ctx = document.getElementById('flipbookViewsChart').getContext('2d');
    
    // Sample data - replace with actual data from your backend
    const data = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Flipbook Views',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: 'rgba(38, 174, 97, 0.2)',
            borderColor: 'rgba(38, 174, 97, 1)',
            borderWidth: 1
        }]
    };

    new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}