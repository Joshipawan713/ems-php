// common.js - Common JavaScript for all pages

document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar
    const toggleSidebarBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    
    if (toggleSidebarBtn && sidebar) {
        toggleSidebarBtn.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
        
        // Auto collapse sidebar on mobile
        if (window.innerWidth <= 992) {
            sidebar.classList.add('collapsed');
        }
    }
    
    // Update active nav link based on current page
    function setActiveNavLink() {
        const currentPage = window.location.pathname.split('/').pop();
        const navLinks = document.querySelectorAll('.sidebar .nav-link');
        
        navLinks.forEach(link => {
            link.classList.remove('active');
            const href = link.getAttribute('href');
            if (href === currentPage) {
                link.classList.add('active');
            }
        });
    }
    
    // Call function to set active nav link
    setActiveNavLink();
});