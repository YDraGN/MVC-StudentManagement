// ============================================
// MAIN JAVASCRIPT FILE
// ============================================

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
    initMobileMenu();
    initSmoothScroll();
    initAnimations();
    setActiveNavLink();
});

// ============================================
// MOBILE MENU TOGGLE
// ============================================
function initMobileMenu() {
    const menuToggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('.nav');
    
    if (menuToggle && nav) {
        menuToggle.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevent event bubbling
            nav.classList.toggle('active');
            
            // Update display based on active state
            const isPortrait = window.innerWidth < window.innerHeight || window.innerWidth <= 768;
            if (isPortrait) {
                if (nav.classList.contains('active')) {
                    nav.style.display = 'block';
                } else {
                    nav.style.display = 'none';
                }
            }
            
            // Animate menu toggle icon
            const icon = this.textContent.trim();
            if (icon === '☰') {
                this.textContent = '✕';
            } else {
                this.textContent = '☰';
            }
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!nav.contains(event.target) && !menuToggle.contains(event.target)) {
                nav.classList.remove('active');
                menuToggle.textContent = '☰';
                // Update display
                const isPortrait = window.innerWidth < window.innerHeight || window.innerWidth <= 768;
                if (isPortrait) {
                    nav.style.display = 'none';
                }
            }
        });
        
        // Handle responsive navigation based on orientation
        handleResponsiveNav();
        window.addEventListener('resize', handleResponsiveNav);
        window.addEventListener('orientationchange', handleResponsiveNav);
    }
}

// ============================================
// RESPONSIVE NAVIGATION HANDLER
// ============================================
function handleResponsiveNav() {
    const nav = document.querySelector('.nav');
    const menuToggle = document.querySelector('.menu-toggle');
    
    if (!nav || !menuToggle) return;
    
    const isPortrait = window.innerWidth < window.innerHeight || window.innerWidth <= 768;
    
    if (isPortrait) {
        // Portrait or narrow: show toggle button
        menuToggle.style.display = 'block';
        if (nav.classList.contains('active')) {
            // If active, show the nav
            nav.style.display = 'block';
        } else {
            // If not active, hide the nav
            nav.style.display = 'none';
        }
    } else {
        // Landscape and wide: show horizontal nav
        menuToggle.style.display = 'none';
        nav.style.display = 'flex';
        nav.classList.remove('active');
    }
}

// ============================================
// SMOOTH SCROLL
// ============================================
function initSmoothScroll() {
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
}

// ============================================
// SET ACTIVE NAVIGATION LINK
// ============================================
function setActiveNavLink() {
    const currentPath = window.location.pathname;
    const currentSearch = window.location.search;
    
    document.querySelectorAll('.nav-link').forEach(link => {
        const linkPath = new URL(link.href).pathname;
        const linkSearch = new URL(link.href).search;
        
        // Check if it's the current page
        if (linkPath.includes(currentPath) || 
            (currentSearch && linkSearch && currentSearch.includes(linkSearch))) {
            link.classList.add('active');
        }
    });
}

// ============================================
// ANIMATIONS
// ============================================
function initAnimations() {
    // Fade in elements on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe all containers
    document.querySelectorAll('.container').forEach(container => {
        container.style.opacity = '0';
        container.style.transform = 'translateY(20px)';
        container.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(container);
    });
    
    // Animate table rows
    const tableRows = document.querySelectorAll('table tbody tr');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateX(-10px)';
        row.style.transition = `opacity 0.3s ease ${index * 0.05}s, transform 0.3s ease ${index * 0.05}s`;
        
        setTimeout(() => {
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
        }, 100);
    });
}

// ============================================
// MODAL FUNCTIONS
// ============================================
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent background scroll
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = ''; // Restore scroll
    }
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.classList.remove('active');
        document.body.style.overflow = '';
    }
});

// ============================================
// FORM VALIDATION ENHANCEMENTS
// ============================================
function enhanceFormValidation() {
    // Add real-time validation feedback
    const inputs = document.querySelectorAll('input[type="text"], input[type="number"]');
    
    inputs.forEach(input => {
        // Add focus effect
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
            this.parentElement.style.transition = 'transform 0.2s ease';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
        
        // Add success state
        input.addEventListener('input', function() {
            if (this.value.trim() && !this.classList.contains('is-invalid')) {
                this.style.borderColor = '#51cf66';
            }
        });
    });
}

// Initialize form enhancements if forms exist
if (document.querySelector('form')) {
    enhanceFormValidation();
}

// ============================================
// UTILITY FUNCTIONS
// ============================================

// Debounce function for performance
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Show notification/toast message
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type}`;
    notification.textContent = message;
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.zIndex = '10000';
    notification.style.minWidth = '300px';
    notification.style.padding = '1rem 1.5rem';
    notification.style.borderRadius = '8px';
    notification.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.15)';
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100px)';
        notification.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Export functions for use in other scripts
window.utils = {
    openModal,
    closeModal,
    showNotification,
    debounce
};

