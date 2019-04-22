// -----------------------------------------
//             IMPORTING JS
// -----------------------------------------
require('../../assets/js/hover.js');
window.Popper = require('popper.js');
require('bootstrap/dist/js/bootstrap.js');
global.$ = global.jQuery = require('jquery');

// -----------------------------------------
//             PAGE PRELOAD
// -----------------------------------------

function isIE() {
    let ua = navigator.userAgent;
    /* MSIE used to detect old browsers and Trident used to newer ones*/
    return ua.indexOf("MSIE ") > -1 || ua.indexOf("Trident/") > -1;
}

/* Create an alert to show if the browser is IE or not */
if (isIE()) {
    document.querySelector('.preloader').style.display = 'none';
    document.querySelector('.pageloader').style.display = 'none';
}

let redirectors = document.querySelectorAll('.redirect');

redirectors.forEach(function (redirector) {
    redirector.addEventListener('click', function (e) {
        e.preventDefault();
        let url = redirector.getAttribute('href');
        $preloader.fadeIn(200);
        $('body').css('overflow', 'hidden');
        setTimeout(() => {
            window.location.href = url;
        }, 200);
    })
});

$preloader = $('.preloader');
$pageloader = $('.pageloader');
document.addEventListener('DOMContentLoaded', (event) => {
    $preloader.hide();
    setTimeout(() => {
        $pageloader.fadeOut(300);
    }, 1);
    setTimeout(() => {
        $('body').css('overflow', 'unset');
    }, 300);
});


// -----------------------------------------
//             MOBILE NAV TOGGLER
// -----------------------------------------

$("#mobile-nav-toggler").click(function () {
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

$(window).scroll(function (event) {
    didScroll = true;
});

setInterval(function () {
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
    $(".categories-items li").click(function () {

        let category = $(this).attr('data-filter');
        $('.categories-items li').removeClass('active');
        $(this).addClass('active');
        if (category === '') {
            $('.cover-up').fadeIn(200);
            setTimeout(() => {
                $('.gallery-item:hidden').show().removeClass('hidden');
            }, 200);
            $('.cover-up').fadeOut(200);
        } else {
            $('.cover-up').fadeIn(200);
            setTimeout(() => {
                $('.gallery-item').each(function () {
                    if (!$(this).hasClass(category)) {
                        $(this).hide().addClass('hidden');
                    } else {
                        $(this).show().removeClass('hidden');
                    }
                });
            }, 200);
            $('.cover-up').fadeOut(200);
        }
        return false
    });
    $(".categories-items li:first").trigger("click").addClass('active');
});

// ---------------------------------------------------
// CONTENT - ADDED CUSTOM TOUCH SUPPORT FOR CAROUSEL
// ---------------------------------------------------

let pageWidth = window.innerWidth || document.body.clientWidth;
let treshold = Math.max(1, Math.floor(0.01 * (pageWidth)));
let touchstartX = 0;
let touchstartY = 0;
let touchendX = 0;
let touchendY = 0;

const limit = Math.tan(45 * 1.5 / 180 * Math.PI);
const gestureZone = document.getElementsByTagName('body');

gestureZone[0].addEventListener('touchstart', function (event) {
    touchstartX = event.changedTouches[0].screenX;
    touchstartY = event.changedTouches[0].screenY;
}, false);

gestureZone[0].addEventListener('touchend', function (event) {
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
                $(function () {
                    $('.carousel').carousel('next');
                });
            } else {
                $(function () {
                    $('.carousel').carousel('prev');
                });
            }
        }
    }
}

// -----------------------------------------
//             AJAX EMAIL
// -----------------------------------------

let contactForm = document.querySelector('.contact-email-form');
if (document.body.contains(contactForm)) {
// -----------------------------------------
//             AJAX EMAIL VALIDATION
// -----------------------------------------

    let nameField = document.querySelector('.name');
    let subjectField = document.querySelector('.subject');
    let emailField = document.querySelector('.field.email');
    let commentField = document.querySelector('.comment');
    let submitBtn = document.querySelector('.submit-btn');

    nameField.addEventListener('blur', validateName);
    emailField.addEventListener('blur', validateEmail);
    subjectField.addEventListener('blur', validateSubject);
    commentField.addEventListener('blur', validateComment);

    function validateName() {
        const re = /^[a-zA-Z\ \  ]{2,50}$/;

        if (!re.test(nameField.value)) {
            nameField.style.border = '1px solid #BF5329';
            submitBtn.style.pointerEvents = 'none';
            submitBtn.style.opacity = '0.5';
        } else {
            nameField.style.border = '1px solid #2AB27B';
            submitBtn.style.pointerEvents = 'unset';
            submitBtn.style.opacity = 'unset';
        }
    }

    function validateSubject() {
        const re = /^[a-zA-Z\ \  ]{2,50}$/;

        if (!re.test(subjectField.value)) {
            subjectField.style.border = '1px solid #BF5329';
            submitBtn.style.pointerEvents = 'none';
            submitBtn.style.opacity = '0.5';
        } else {
            subjectField.style.border = '1px solid #2AB27B';
            submitBtn.style.pointerEvents = 'unset';
            submitBtn.style.opacity = 'unset';
        }
    }

    function validateEmail() {
        const re = /^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{1,6})$/;

        if (!re.test(emailField.value)) {
            emailField.style.border = '1px solid #BF5329';
            submitBtn.style.pointerEvents = 'none';
            submitBtn.style.opacity = '0.5';
        } else {
            emailField.style.border = '1px solid #2AB27B';
            submitBtn.style.pointerEvents = 'unset';
            submitBtn.style.opacity = 'unset';
        }
    }

    function validateComment() {
        const re = /^[a-zA-Z0-9_\-\.\!\?\'\"\,\/\(\)\%\=\+\*\:\;\@\ \  ]{1,300}$/;

        if (!re.test(commentField.value)) {
            commentField.style.border = '1px solid #BF5329';
            submitBtn.style.pointerEvents = 'none';
            submitBtn.style.opacity = '0.5';
        } else {
            commentField.style.border = '1px solid #2AB27B';
            submitBtn.style.pointerEvents = 'unset';
            submitBtn.style.opacity = 'unset';
        }
    }

    let url = contactForm.dataset.url;

    $(document).ready(function () {
        $('.loader-container').hide();
        $('.submit-btn').on('click', function (e) {
            let self = $(this);
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'post',
                data: {
                    name: self.closest(contactForm).find('input[name="name"]').val(),
                    subject: self.closest(contactForm).find('input[name="subject"]').val(),
                    email: self.closest(contactForm).find('input[name="email"]').val(),
                    comment: self.closest(contactForm).find('textarea[name="comment"]').val(),
                    contact_id: self.closest(contactForm).find('input[name="contact_id"]').val(),

                },
                beforeSend: function () {
                    $('.loader-container').show();
                },

                success: function (result) {
                    if (result.errors) {
                        $('.loader-container').hide();
                        $(".errors").fadeIn(200);
                        $('.errors .errors-list').empty();
                        $.each(result.errors, function (key, value) {
                            $('.errors .errors-list').append('<li>' + value + '</li>');
                        });
                        setTimeout(function () {
                            $(".errors").fadeOut(200);
                        }, 5000);
                    } else {
                        $('.loader-container').hide();
                        $(".success").fadeIn(200);
                        $.each(result, function (key, value) {
                            $('.success h5').html(result.success);
                        });
                        setTimeout(function () {
                            $(".success").fadeOut(200);
                        }, 5000);
                    }
                }
            });
        });
    });

}


function clock() {
    let time = new Date(),
    hours = time.getHours(),
    minutes = time.getMinutes(),
    seconds = time.getSeconds();
    document.querySelectorAll('.clock')[0].innerHTML = harold(hours) + ":" + harold(minutes) + ":" + harold(seconds);

    function harold(standIn) {
        if (standIn < 10) {
            standIn = '0' + standIn
        }
        return standIn;
    }
}

setInterval(clock, 1000);

function ourclock() {
    let date = new Date();
    let offset = date.getTimezoneOffset();

    date.setMinutes(date.getMinutes() + offset);
    let sofiaOffset = 3*60;
    date.setMinutes(date.getMinutes() + sofiaOffset);

    document.querySelectorAll('.our-clock')[0].innerHTML = harold(date.getHours()) + ":" + harold(date.getMinutes()) + ":" + harold(date.getSeconds());
    function harold(standIn) {
        if (standIn < 10) {
            standIn = '0' + standIn
        }
        return standIn;
    }
}

setInterval(ourclock, 1000);

