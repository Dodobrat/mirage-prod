// -----------------------------------------
//             IMPORTING JS
// -----------------------------------------
require('../../assets/js/hover.js');
window.Popper = require('popper.js');
require('bootstrap/dist/js/bootstrap.js');
global.$ = global.jQuery = require('jquery');

// -----------------------------------------
//             MOBILE NAV TOGGLER
// -----------------------------------------

$("#mobile-nav-toggler").click(function(){
    $('#hamburger').toggleClass('is-active');
});

// -----------------------------------------
//             DIRECTIONAL HOVER
// -----------------------------------------

$(function () {
    $('.gallery-item > .gallery-card').hoverdir();
});

// -----------------------------------------
//             HIDE NAV ON SCROLL
// -----------------------------------------

let didScroll;
let lastScrollTop = 0;
let delta = 5;
let navbarHeight = $('.nav-container').outerHeight();

$(window).scroll(function(event) {
    didScroll = true;
});

setInterval(function() {
    if (didScroll) {
        hasScrolled();
        didScroll = false;
    }
}, 250);

function hasScrolled() {
    let st = $(this).scrollTop();
    if (Math.abs(lastScrollTop - st) <= delta)
        return;
    if (st > lastScrollTop && st > navbarHeight) {
        // Scroll Down
        $('.nav-container').addClass('nav-up').removeClass('nav-down');
    } else {
        // Scroll Up
        if (st + $(window).height() < $(document).height()) {
            $('.nav-container').removeClass('nav-up').addClass('nav-down');
        }
    }
    lastScrollTop = st;
}

// -----------------------------------------
//             FILTER GALLERY
// -----------------------------------------


$(document).ready(function () {
    $("#test li").click(function () {

        let category = $(this).attr('data-filter');
        $('#test li').removeClass('active');
        $(this).addClass('active');
        if (category === '') {
            $('.gallery-item:hidden').show().removeClass('hidden');
        }
        else {
            $('.gallery-item').each(function () {
                if (!$(this).hasClass(category) && !$(this).hasClass('without')) {
                    $(this).hide().addClass('hidden');
                } else {
                    $(this).show().removeClass('hidden');
                }
            });
        }
        return false
    });
    $("#test li:first").trigger("click").addClass('active');
});





// -----------------------------------------
//             PROJECT MODAL
// -----------------------------------------

const modal = document.querySelector('#my-modal');
const modalContent = document.querySelector('.project-modal-content');
const modalBtn = document.querySelector('#modal-btn');
const closeBtn = document.querySelector('.project-modal-close-btn');

// Events
modalBtn.addEventListener('click', openModal);
closeBtn.addEventListener('click', closeModal);

// Open
function openModal() {
    $(modal).slideDown(300);
    document.querySelector('body').style.overflowY = 'hidden';
    setTimeout(function () {
        $(modalContent).fadeIn(200);
    }, 300);
    $(document).keyup(function(e) {
        if (e.keyCode === 27){
            closeModal();
        }
        if (e.keyCode === 37){
            $('a.carousel-control-prev').trigger('click');
        }
        if (e.keyCode === 39){
            $('a.carousel-control-next').trigger('click');
        }

    });
}

// Close
function closeModal() {
    $(modalContent).fadeOut(200);
    document.querySelector('body').style.overflowY = 'auto';
    setTimeout(function () {
        $(modal).slideUp(300);
    }, 200);
}

// ---------------------------------------------------
//         CONTENT - ADDED CUSTOM TOUCH SUPPORT FOR CAROUSEL
// ---------------------------------------------------
let pageWidth = window.innerWidth || document.body.clientWidth;
let treshold = Math.max(1,Math.floor(0.01 * (pageWidth)));
let touchstartX = 0;
let touchstartY = 0;
let touchendX = 0;
let touchendY = 0;

const limit = Math.tan(45 * 1.5 / 180 * Math.PI);
const gestureZone = document.getElementsByTagName('body');

gestureZone[0].addEventListener('touchstart', function(event) {
    touchstartX = event.changedTouches[0].screenX;
    touchstartY = event.changedTouches[0].screenY;
}, false);

gestureZone[0].addEventListener('touchend', function(event) {
    touchendX = event.changedTouches[0].screenX;
    touchendY = event.changedTouches[0].screenY;
    handleGesture(event);
}, false);

function handleGesture(e) {
    let x = touchendX - touchstartX;
    let y = touchendY - touchstartY;
    let yx = Math.abs(y / x);
    if (Math.abs(x) > treshold || Math.abs(y) > treshold) {
        if (yx <= limit) {
            if (x < 0) {
                $(function(){
                    $('.carousel').carousel('next');
                });
            } else {
                $(function(){
                    $('.carousel').carousel('prev');
                });
            }
        }
    }
}
