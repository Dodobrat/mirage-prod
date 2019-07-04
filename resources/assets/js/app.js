// -----------------------------------------
//             IMPORTING JS
// -----------------------------------------
require('../../assets/js/hover.js');
window.Popper = require('popper.js');
require('bootstrap/dist/js/bootstrap.js');
global.$ = global.jQuery = require('jquery');
global.Parallax = require('parallax-js/dist/parallax.min.js');
global.owlCarousel = require('owl.carousel/dist/owl.carousel.min.js');

// -----------------------------------------
//             PAGE PRELOAD
// -----------------------------------------

function isIE() {
    let ua = navigator.userAgent;0
    /* MSIE used to detect old browsers and Trident used to newer ones*/
    return ua.indexOf("MSIE ") > -1 || ua.indexOf("Trident/") > -1;
}

/* Create an alert to show if the browser is IE or not */
if (isIE()) {
    document.querySelector('.preloader').style.display = 'none';
    document.querySelector('.pageloader').style.display = 'none';
}

let redirectors = document.querySelectorAll('.redirect');

for (let i = 0; i < redirectors.length; i++) {
    redirectors[i].addEventListener('click', function (e) {
        e.preventDefault();
        let url = this.getAttribute('href');
        $preloader.fadeIn(300);
        setTimeout(() => {
            window.location.href = url;
        }, 300);
    })
}

$preloader = $('.preloader');
$pageloader = $('.pageloader');
document.addEventListener('DOMContentLoaded', (e) => {
    $preloader.hide();
    setTimeout(() => {
        $pageloader.fadeOut(500);
    }, 500);
});


// -----------------------------------------
//             PARALLAX EFFECT
// -----------------------------------------


let scene = document.getElementById('scene');
if (document.body.contains(scene)) {
    let parallaxInstance = new Parallax(scene, {
        invertX: false,
        invertY: false,
        hoverOnly: true,
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

(function () {
    let x, newX, left, down;

    let categories = $('.categories-items li');

    function scrolling() {
        categories.css('pointer-events', 'none');
    }

    function clickable() {
        categories.css('pointer-events', 'unset');
    }

    $(".categories-items").mousedown(function (e) {
        down = true;
        x = e.pageX;
        left = $(this).scrollLeft();
    });

    $(".categories-items").mousemove(function (e) {
        e.preventDefault();
        if (down) {
            newX = e.pageX;
            $(this).scrollLeft(left + x - newX);
        }
    });

    $("body").mouseup(function (e) {
        down = false;
        clickable();
    });

    $("body").keydown(function (e) {
        left = $(".categories-items").scrollLeft();
        let articleWidth = $('.categories-item').width();
        let margin = 2 * parseInt($('.categories-item').css("marginLeft"));
        if (e.keyCode == 39)
            $(".categories-items").scrollLeft(left + articleWidth + margin);
        if (e.keyCode == 37)
            $(".categories-items").scrollLeft(left - articleWidth - margin);
    });

    //MOBILE
    let slideDiv = $('.categories-items');
    slideDiv.on('touchstart', function () {
        let touches = event.changedTouches;
        down = true;
        x = touches[0].pageX;
        left = $('.categories-items').scrollLeft();
    });

    slideDiv.on('touchmove', function (event) {
        event.stopPropagation();
        let touches = event.changedTouches;
        if (down) {
            scrolling();
            let newX = touches[0].pageX;
            $('.categories-items').scrollLeft(left + x - newX);
        }
    });

    slideDiv.on('touchend', function () {
        down = false;
        clickable();
    });
})();

// -----------------------------------------
//             PROJECTS PAGINATION
// -----------------------------------------
if (document.body.contains(document.querySelector('.ajax-projects'))) {

    let loader = $('.load-more-projects-loader');
    let fired = false;

    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() > $(document).height() - 500 && fired === false) {
            let selected_category = $('.categories-items .categories-item.active').data('filter');
            let pageNum = parseInt($('#page').val());
            fetchData(pageNum, selected_category);
            fired = true;
        }
    });

    let category = $(".categories-items li");

    category.on('click', function (e) {
        e.preventDefault();
        let projects = $('.ajax-projects');
        projects.html('');
        let category_filter = $(this).data('filter');
        let newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?category=' + category_filter;
        window.history.pushState({path: newurl}, '', newurl);
        category.removeClass('active');
        $(this).addClass('active');
        let pageNum = 1;
        fetchData(pageNum, category_filter);
    });

    $(document).ready(function () {
        if (window.location.href.indexOf('?category=') > 0) {
            let projects = $('.ajax-projects');
            projects.html('');
            let category_filter = window.location.href.split('category=')[1];
            $('.categories-items li[data-filter="' + category_filter + '"]').addClass('active');
            let pageNum = 1;
            let target = $('.categories-items li.active');
            $('.categories-items').animate({
                scrollLeft: $(target).position().left
            }, 1500);
            fetchData(pageNum, category_filter);
        } else {
            $('.categories-items li:first').addClass('active');
        }
    });

    window.fetchData = function (page, cat) {
        let url = $('.ajax-projects').data('url');
        let type = $('.ajax-projects').data('type');
        let projects = $('.ajax-projects');
        let no_projects = `<div class="w-100"><p class="no-projects">No Projects!</h2></div>`;

        $.ajaxSetup({
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            method: 'post',
            data: {
                page: page,
                category: cat,
                type: type
            },
            beforeSend: function () {
                loader.fadeIn();
            },

            success: function (result) {
                if (result.errors.length !== 0) {
                    $(".errors").fadeIn(200);
                    $('.errors .errors-list').empty();
                    $.each(result.errors, function (key, value) {
                        $('.errors .errors-list').append('<li>' + value + '</li>');
                    });
                    setTimeout(function () {
                        $(".errors").fadeOut(200);
                    }, 5000);
                    loader.fadeOut();
                } else {
                    loader.fadeOut();

                    projects.append(result.projects_grid);
                    if (result.projects_grid.length > 200) {
                        $('#page').val(parseInt(page) + 1);
                        fired = false;

                    }
                    $(function () {
                        $('.gallery-item > .gallery-card').hoverdir();
                    });
                    if ($('.ajax-projects .row.align-items-center .gallery-item').length < 1) {
                        projects.html(no_projects);

                    }
                }
            }
        });
    };

}

// -----------------------------------------
//             PROJECT MODAL
// -----------------------------------------

let $modal = $('#my-modal');
let $modalContent = $('.project-modal-content');
let $modalBtn = $('#modal-btn');
let $closeBtn = $('.project-modal-close-btn');

// Open
window.openModal = function (id, slug) {
    let projectId = id;
    let projectUrl = $('.keep-aspect').data('url');
    $.ajaxSetup({
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: projectUrl,
        method: 'post',
        data: {
            project_id: projectId,
        },
        beforeSend: function () {
            $('.loading').slideDown(500);
        },

        success: function (result) {
            if (result.errors.length !== 0) {
                $('.loading').slideUp(500);
                $(".errors").fadeIn(200);
                $('.errors .errors-list').empty();
                $.each(result.errors, function (key, value) {
                    $('.errors .errors-list').append('<li>' + value + '</li>');
                });
                setTimeout(function () {
                    $(".errors").fadeOut(200);
                }, 5000);
            } else {
                let newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?project=' + projectId;
                window.history.pushState({path: newurl}, '', newurl);
                $modal.fadeIn(300);
                $('body').css('overflow','hidden');
                $modal.html(result.project_modal);
                let images = document.querySelectorAll(".lazy-load");
                for (let i = 0; i < images.length; i++) {
                    images[i].src = images[i].getAttribute('data-src');
                }
                let $owl = $( '.owl-modal-gallery' );
                $owl.owlCarousel({
                    margin: 20,
                    center: true,
                    loop:true,
                    nav:true,
                    pagination: true,
                    items:1
                });
                $(document).on('keydown', function( e ) {
                    if (e.keyCode === 27) {
                        closeModal();
                    }
                    if (e.keyCode === 37) {
                        $owl.trigger('prev.owl.carousel');
                    }
                    if (e.keyCode === 39) {
                        $owl.trigger('next.owl.carousel');
                    }
                });
            }
        }
    });
};

// Close
window.closeModal = function () {
    let url = window.location.href;
    if (url.indexOf('?') > 0) {
        let clean_url = url.substring(0, url.indexOf("?"));
        window.history.replaceState({}, document.title, clean_url);
    }
    $modal.fadeOut(300);
    $('body').css('overflow','auto');
    $('.loading').slideUp(500);
};

$(document).ready(function () {
    if (window.location.href.indexOf('?project=') > 0) {
        let projectId = window.location.href.split('project=')[1];
        openModal(projectId);
    }
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
                    captcha: self.closest(contactForm).find('textarea[name="g-recaptcha-response"]').val(),
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
                        $('.submit-btn').css('pointer-events', 'none');
                        $('.submit-btn').css('opacity', 0.7);
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
//             WORKFLOW ACCESS
// -----------------------------------------

let workflowContent = document.querySelector('#workflow_content');
let contentHider = document.querySelector('.hide-content-container');

window.getWorkflow = function (id, slug, url) {
    let workflowId = id;
    let workflowUrl = url;
    let workflowSlug = slug;
    let accessKey = $('.access-input').val();

    $.ajaxSetup({
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: workflowUrl,
        method: 'post',
        data: {
            workflow_id: workflowId,
            access_key: accessKey,
            workflow_slug: workflowSlug,
        },
        beforeSend: function () {
            $('.loader-container').show();
        },

        success: function (result) {
            if (result.errors.length !== 0) {
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
                $(contentHider).fadeOut(300);
                workflowContent.innerHTML = result.workflow_content;
                setTimeout(function () {
                    $(workflowContent).fadeIn(500);
                }, 350);
                // -----------------------------------------
                //             WORKFLOW GALLERY
                // -----------------------------------------
                let images = document.querySelectorAll(".workflow-load");
                for (let i = 0; i < images.length; i++) {
                    images[i].src = images[i].getAttribute('data-src');
                }
                $('.owl-workflow').owlCarousel({
                    margin: 10,
                    center: true,
                    loop:true,
                    nav:true,
                    pagination: true,
                    items:1
                });
                $(document).on('keydown', function( e ) {
                    if (e.keyCode === 70) {
                        openWorkflowModal();
                    }
                    if (e.keyCode === 37) {
                        $('.owl-workflow').trigger('prev.owl.carousel');
                    }
                    if (e.keyCode === 39) {
                        $('.owl-workflow').trigger('next.owl.carousel');
                    }
                });
                let full_screen_expander = $('#workflow-modal');
                let workflow_modal = $('.workflow-modal-container');
                full_screen_expander.on('click', openWorkflowModal);

                function openWorkflowModal() {
                    $('body').css('overflow','hidden');
                    workflow_modal.fadeIn(200);
                    let modal_images = document.querySelectorAll(".modal-workflow-load");
                    for (let i = 0; i < modal_images.length; i++) {
                        modal_images[i].src = modal_images[i].getAttribute('data-src');
                    }
                    $('.owl-modal-workflow').owlCarousel({
                        margin: 10,
                        center: true,
                        loop:true,
                        nav:true,
                        pagination: true,
                        items:1
                    });
                    $(document).on('keydown', function( e ) {
                        if (e.keyCode === 27) {
                            workflow_modal.fadeOut(200);
                            $('body').css('overflow','auto');
                        }
                        if (e.keyCode === 37) {
                            $('.owl-modal-workflow').trigger('prev.owl.carousel');
                        }
                        if (e.keyCode === 39) {
                            $('.owl-modal-workflow').trigger('next.owl.carousel');
                        }
                    });
                };
                let close_workflow_modal = $('.close-workflow-modal');
                close_workflow_modal.on('click', function () {
                    workflow_modal.fadeOut(200);
                    $('body').css('overflow','auto');
                })
            }
        }
    });
};


// -----------------------------------------
//             BACK TO TOP
// -----------------------------------------
$btn = $('.to-top');
$btn.hide();
$(window).scroll(function () {
    if ($(window).scrollTop() > 300) {
        $btn.fadeIn(300);
    } else {
        $btn.fadeOut(300);
    }
});

$btn.on('click', function (e) {
    e.preventDefault();
    $('html, body').animate({scrollTop: 0}, '300');
});

