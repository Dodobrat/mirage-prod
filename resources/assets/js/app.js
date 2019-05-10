// -----------------------------------------
//             IMPORTING JS
// -----------------------------------------
require('../../assets/js/hover.js');
window.Popper = require('popper.js');
require('bootstrap/dist/js/bootstrap.js');
global.$ = global.jQuery = require('jquery');
global.Parallax = require('parallax-js/dist/parallax.min.js');

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
        $preloader.fadeIn(300);
        setTimeout(() => {
            window.location.href = url;
        }, 300);
    })
});

$preloader = $('.preloader');
$pageloader = $('.pageloader');
document.addEventListener('DOMContentLoaded', (event) => {
    $preloader.hide();
    setTimeout(() => {
        $pageloader.fadeOut(500);
    }, 500);
});


// -----------------------------------------
//             PARALLAX EFFECT
// -----------------------------------------


var scene = document.getElementById('scene');
if(document.body.contains(scene)){
    var parallaxInstance = new Parallax(scene,{
        relativeInput: true,
        hoverOnly: false,
    });
}

// -----------------------------------------
//             MOBILE NAV TOGGLER
// -----------------------------------------

$("#mobile-nav-toggler").click(function () {
    $('#hamburger').toggleClass('is-active');
});

// -----------------------------------------
//             CATEGORY SLIDE
// -----------------------------------------

(function() {
    let x,newX,left,down;

    let categories = $('.categories-items li');

    function scrolling(){
        categories.css('pointer-events','none');
    }

    function clickable(){
        categories.css('pointer-events','unset');
    }

    $(".categories-items").mousedown(function(e) {
        down = true;
        x = e.pageX;
        left = $(this).scrollLeft();
    });

    $(".categories-items").mousemove(function(e) {
        e.preventDefault();
        if (down) {
            newX = e.pageX;
            $(this).scrollLeft(left+x-newX);
        }
    });

    $("body").mouseup(function(e) {
        down=false;
        clickable();
    });

    $("body").keydown(function(e) {
        left = $(".categories-items").scrollLeft();
        let articleWidth = $('.categories-item').width();
        let margin = 2*parseInt($('.categories-item').css("marginLeft"));
        if (e.keyCode == 39)
            $(".categories-items").scrollLeft(left + articleWidth + margin);
        if (e.keyCode == 37)
            $(".categories-items").scrollLeft(left - articleWidth - margin);
    });

    //MOBILE
    let slideDiv = $('.categories-items');
    slideDiv.on('touchstart', function() {
        let touches = event.changedTouches;
        down = true;
        x = touches[0].pageX;
        left = $('.categories-items').scrollLeft();
    });

    slideDiv.on('touchmove', function(event){
        event.stopPropagation();
        let touches = event.changedTouches;
        if (down) {
            scrolling();
            let newX = touches[0].pageX;
            $('.categories-items').scrollLeft(left+x-newX);
        }
    });

    slideDiv.on('touchend', function(){
        down = false;
        clickable();
    });
})();

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
                    $('.loader').show();
                },

                success: function (result) {
                    if (result.errors) {
                        $('.loader').hide();
                        $(".errors").fadeIn(200);
                        $('.errors .errors-list').empty();
                        $.each(result.errors, function (key, value) {
                            $('.errors .errors-list').append('<li>' + value + '</li>');
                        });
                        setTimeout(function () {
                            $(".errors").fadeOut(200);
                        }, 5000);
                    } else {
                        $('.loader').hide();
                        $('.submit-btn').css('pointer-events','none');
                        $('.submit-btn').css('opacity',0.7);
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

// -----------------------------------------
//             TIMEZONE INFORMATION
// -----------------------------------------
if (document.body.contains(document.querySelector('.clock')) && document.body.contains(document.querySelector('.our-clock'))) {

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
        let sofiaOffset = 3 * 60;
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
}

// -----------------------------------------
//             BACK TO TOP
// -----------------------------------------
$btn = $('.to-top');
$btn.hide();
$(window).scroll(function() {
    if ($(window).scrollTop() > 300) {
        $btn.fadeIn(300);
    } else {
        $btn.fadeOut(300);
    }
});

$btn.on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({scrollTop:0}, '300');
});

