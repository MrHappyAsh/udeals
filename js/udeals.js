// Debounce function to limit the rate at which a function can fire
function debounce(func, wait, immediate) {
    let timeout;
    return function() {
        const context = this, args = arguments;
        const later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}

// Adjusts the layout based on the presence of the admin bar and header height
function adjustLayout() {
    const header = document.querySelector('.site-header');
    const adminBar = document.getElementById('wpadminbar');
    const menuContainer = document.querySelector('.menu-menu-1-container');

    const adminBarHeight = adminBar ? adminBar.offsetHeight : 0;

    menuContainer.style.top = `${header.offsetHeight + adminBarHeight}px`;
}

// Sets the fixed width of summaryBlockInners
function setFixedWidth() {
    const summaryBlock = document.querySelector('.summary_block');
    const summaryBlockInners = document.querySelector('.summary_block_inners');
    const viewportWidth = window.innerWidth;

    if (viewportWidth > 800 && summaryBlock && summaryBlockInners) {
        summaryBlockInners.style.width = (summaryBlock.offsetWidth - 10) + 'px';
    } else if (viewportWidth <= 800) {
        summaryBlockInners.style.width = 'auto'; // Reset width for mobile
    }
}

// Handles scroll events to adjust positioning of the summary block
function handleScroll() {
    const viewportWidth = window.innerWidth;
    if (viewportWidth <= 800) return; // Do not apply any special scroll behavior under 800px

    const summaryBlock = document.querySelector('.summary_block');
    const summaryBlockInners = document.querySelector('.summary_block_inners');
    if (!summaryBlockInners || !summaryBlock) return;

    const header = document.querySelector('.site-header');
    const adminBar = document.getElementById('wpadminbar');
    const adminBarHeight = adminBar ? adminBar.offsetHeight : 0;
    const headerHeight = header ? header.offsetHeight : 0;

    const offsetTop = summaryBlock.offsetTop + headerHeight + adminBarHeight;
    const innerHeight = summaryBlockInners.getBoundingClientRect().height;
    let maxTopPosition = window.scrollY + summaryBlock.getBoundingClientRect().top + summaryBlock.getBoundingClientRect().height - innerHeight - headerHeight - adminBarHeight;

    if (window.scrollY + headerHeight + adminBarHeight > offsetTop) {
        if (window.scrollY + innerHeight + headerHeight + adminBarHeight > maxTopPosition) {
            summaryBlockInners.style.position = 'absolute';
            summaryBlockInners.style.top = (summaryBlock.getBoundingClientRect().height - innerHeight) + 'px';
        } else {
            summaryBlockInners.style.position = 'fixed';
            summaryBlockInners.style.top = `${headerHeight + adminBarHeight}px`;
        }
    } else {
        summaryBlockInners.style.position = 'absolute';
        summaryBlockInners.style.top = '0';
    }
}

// Toggles the menu open and close
function toggleMenu() {
    let menuToggle = document.querySelector('.menu-toggle');
    let menuContainer = document.querySelector('#primary-menu-container');
    let body = document.body;

    menuToggle.addEventListener('click', function() {
        // Toggle the 'open' class
        this.classList.toggle('open');

        // Correctly toggle the 'aria-expanded' state
        let expanded = this.getAttribute('aria-expanded') === 'true';
        if (expanded) {
            this.setAttribute('aria-expanded', 'true');
            menuContainer.style.display = 'flex'; // Or 'block', depending on your CSS
            body.classList.add('body-no-scroll');
        } else {
            this.setAttribute('aria-expanded', 'false');
            menuContainer.style.display = 'none';
            body.classList.remove('body-no-scroll');
        }
    });
}

function scrollToSummary() {
    const summaryBlock = document.querySelector('.summary_block');
    if (summaryBlock) {
        summaryBlock.scrollIntoView({ behavior: 'smooth' });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    toggleMenu();
    adjustLayout();
    setFixedWidth();
    handleScroll();
});

window.addEventListener('resize', debounce(() => {
    adjustLayout();
    setFixedWidth();
}, 250));

window.addEventListener('scroll', handleScroll);