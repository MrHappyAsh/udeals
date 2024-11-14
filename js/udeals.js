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

    header.style.top = `${adminBarHeight}px`;
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
// function handleScroll() {
//     const viewportWidth = window.innerWidth;
//     if (viewportWidth <= 800) return; // Do not apply any special scroll behavior under 800px

//     const summaryBlock = document.querySelector('.summary_block');
//     const summaryBlockInners = document.querySelector('.summary_block_inners');
//     if (!summaryBlockInners || !summaryBlock) return;

//     const header = document.querySelector('.site-header');
//     const adminBar = document.getElementById('wpadminbar');
//     const adminBarHeight = adminBar ? adminBar.offsetHeight : 0;
//     const headerHeight = header ? header.offsetHeight : 0;

//     const offsetTop = summaryBlock.getBoundingClientRect().top + window.scrollY - headerHeight - adminBarHeight;
//     const summaryBlockHeight = summaryBlock.getBoundingClientRect().height;
//     const innerHeight = summaryBlockInners.getBoundingClientRect().height;
//     const maxScrollY = offsetTop + summaryBlockHeight - innerHeight;

//     if (window.scrollY > offsetTop) {
//         if (window.scrollY > maxScrollY) {
//             summaryBlockInners.style.position = 'absolute';
//             summaryBlockInners.style.top = `${summaryBlockHeight - innerHeight}px`;
//         } else {
//             summaryBlockInners.style.position = 'fixed';
//             summaryBlockInners.style.top = `${headerHeight + adminBarHeight}px`;
//         }
//     } else {
//         summaryBlockInners.style.position = 'absolute';
//         summaryBlockInners.style.top = '0';
//     }
// }

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
    const summaryBlock = document.querySelector('.summary_block--mobile');
    if (summaryBlock) {
        summaryBlock.scrollIntoView({ behavior: 'smooth' });
    }
}

function addCountyValidation() {
    var countyField = document.querySelector('#shipping-state');
    if (countyField) {
        countyField.setAttribute('required', 'required');
        countyField.ariaLabel = 'County';
        var label = document.querySelector('label[for=shipping-state]');
        if (label) {
            label.textContent = label.textContent.replace(' (optional)', '');
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    toggleMenu();
    adjustLayout();
    // setFixedWidth();
    // handleScroll();
    setTimeout(addCountyValidation, 2500);
});

window.addEventListener('resize', debounce(() => {
    adjustLayout();
    // setFixedWidth();
}, 250));

// window.addEventListener('scroll', handleScroll);

document.body.addEventListener('updated_checkout', function() {
    addCountyValidation();
});

// document.addEventListener('DOMContentLoaded', function() {
//     var variationForms = document.querySelectorAll('form.variations_form');

//     variationForms.forEach(function(form) {
//         var selects = form.querySelectorAll('select');

//         selects.forEach(function(select) {
//             if (!select.value) {
//                 var firstOption = select.querySelector('option[value]:not([value=""])');
//                 if (firstOption) {
//                     select.value = firstOption.value;
//                     var event = new Event('change', { bubbles: true });
//                     select.dispatchEvent(event);
//                 }
//             }
//         });
//     });
// });

document.addEventListener('DOMContentLoaded', function () {

    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');

        question.addEventListener('click', () => {
            // Close all open items
            faqItems.forEach(i => i.classList.remove('active'));

            // Open the clicked item
            item.classList.add('active');
        });
    });
});

// JavaScript function to update the main featured image and active thumbnail style
function updateMainImage(selectedThumbnail) {
    // Update the main featured image
    const mainImage = document.getElementById('main-featured-image');
    mainImage.src = selectedThumbnail.src;

    // Remove "active" class from all thumbnails
    const thumbnails = document.querySelectorAll('.product_gallery .thumb img');
    thumbnails.forEach(thumb => thumb.classList.remove('active'));

    // Add "active" class to the clicked thumbnail
    selectedThumbnail.classList.add('active');
}

// when an anchor link is clicked, scroll to the target with a minus offset of 100px
document.addEventListener('click', function(e) {
    if (e.target.tagName === 'A' && e.target.href.includes('#')) {
        e.preventDefault();
        const target = document.querySelector(e.target.getAttribute('href'));
        if (target) {
            window.scrollTo({
                top: target.offsetTop,
                behavior: 'smooth'
            });
        }
    }
});

function scrollReviews(direction) {
    const container = document.querySelector('.product_reviews');
    const scrollAmount = 300; // Adjust scroll distance

    if (direction === 'left') {
        container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    } else if (direction === 'right') {
        container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    }
}

// JavaScript for swipe functionality on mobile
let startX;

function handleTouchStart(event) {
    startX = event.touches[0].clientX;
}

function handleTouchMove(event) {
    if (!startX) return;

    let touch = event.touches[0].clientX;
    let diffX = startX - touch;

    // Adjust threshold as needed for swipe sensitivity
    const swipeThreshold = 50; 

    // Detect swipe direction
    if (diffX > swipeThreshold) {
        scrollReviews('right'); // Swipe left to scroll right
        startX = null; // Reset to prevent multiple triggers
    } else if (diffX < -swipeThreshold) {
        scrollReviews('left'); // Swipe right to scroll left
        startX = null;
    }
}

// Attach touch event listeners to the reviews container
const container = document.querySelector('.product_reviews');
container.addEventListener('touchstart', handleTouchStart, { passive: true });
container.addEventListener('touchmove', handleTouchMove, { passive: true });