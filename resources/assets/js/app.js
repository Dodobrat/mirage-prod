// -----------------------------------------
//             IMPORTING JS
// -----------------------------------------
window.Popper = require('popper.js');
require('bootstrap/dist/js/bootstrap.js');
global.$ = global.jQuery = require('jquery');


// -----------------------------------------
//             MOBILE NAV TOGGLER
// -----------------------------------------
$("#mobile-nav-toggler").click(function(){
    $('#hamburger').toggleClass('is-active');
});
