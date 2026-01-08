<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script>
    // Update time every second
    function updateTime() {
        const now = new Date();
        const timeElement = document.getElementById('currentTime');
        if (timeElement) {
            timeElement.textContent = now.toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            });
        }
    }
    
    setInterval(updateTime, 1000);
    
    // Active navigation
    document.addEventListener('DOMContentLoaded', function() {
        const currentPage = window.location.pathname.split('/').pop() || 'index.php';
        const navLinks = document.querySelectorAll('.nav-link');
        
        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href === currentPage) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
        
        // Add click effect to buttons
        const buttons = document.querySelectorAll('.btn-custom');
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                this.style.transform = 'translateY(0px)';
                setTimeout(() => {
                    this.style.transform = 'translateY(-2px)';
                }, 150);
            });
        });
    });
    
    // Simple chart animation for numbers
    function animateNumbers() {
        const statNumbers = document.querySelectorAll('.stat-card h2');
        statNumbers.forEach(number => {
            const finalValue = parseInt(number.textContent.replace(/[^0-9]/g, ''));
            let startValue = 0;
            const duration = 2000;
            const increment = finalValue / (duration / 16);
            
            const timer = setInterval(() => {
                startValue += increment;
                if (startValue >= finalValue) {
                    number.textContent = finalValue.toLocaleString();
                    clearInterval(timer);
                } else {
                    number.textContent = Math.floor(startValue).toLocaleString();
                }
            }, 16);
        });
    }
    
    // Run animation when page loads
    window.addEventListener('load', animateNumbers);
</script>

</body>
</html>