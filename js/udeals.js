document.addEventListener('DOMContentLoaded', function() {
    let menuToggle = document.querySelector('.menu-toggle');
    let menuContainer = document.querySelector('.menu-menu-1-container');

    menuToggle.addEventListener('click', function() {
        // Toggle the 'open' class
        this.classList.toggle('open');

        // Correctly toggle the 'aria-expanded' state
        let expanded = this.getAttribute('aria-expanded') === 'true';
        if (expanded) {
            this.setAttribute('aria-expanded', 'true');
            menuContainer.style.display = 'flex'; // Or 'block', depending on your CSS
        } else {
            this.setAttribute('aria-expanded', 'false');
            menuContainer.style.display = 'none';
        }
    });
    
});

function adjustLayout() {
    let header = document.querySelector('.site-header');
    let mainContent = document.querySelector('.main-content');
    let adminBar = document.getElementById('wpadminbar');
    let menuContainer = document.querySelector('.menu-menu-1-container');

    let adminBarHeight = adminBar ? adminBar.offsetHeight : 0;

    header.style.marginTop = `${adminBarHeight}px`;
    mainContent.style.paddingTop = `${header.offsetHeight}px`;
    menuContainer.style.top = `${header.offsetHeight}px`;
}

// Debounce function to limit the rate at which a function can fire.
function debounce(func, wait, immediate) {
    let timeout;
    return function() {
        let context = this, args = arguments;
        let later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        let callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}

// Run adjustLayout on DOMContentLoaded and on resize
document.addEventListener('DOMContentLoaded', adjustLayout);
window.addEventListener('resize', debounce(adjustLayout, 250));