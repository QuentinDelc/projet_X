/**************** SCROLL SMOOTH ***************************/
$(document).ready(function(){
    $("a").on('click', function(event) {
        if (this.hash !== "") {
            event.preventDefault();
            var hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 800, function(){
                window.location.hash = hash;
            });
        }
    });
});


/*********** SLIDER ***************/
$('.owl-carousel').owlCarousel({
    loop:true,
    margin:0,
    nav:true,
    autoplay:false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
});

/************ FACEBOOK **********************/
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v3.1&appId=446074062530796&autoLogAppEvents=1';
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


/*************** STICKY MENU ******************/
window.onscroll = function() {stickyMenu()};

var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;

function stickyMenu() {
    if (window.pageYOffset >= sticky) {
        navbar.classList.add("sticky")
    } else {
        navbar.classList.remove("sticky");
    }
}

/************** MENU HAMBURGER **************/
$(document).ready(function(){
    $('#nav-anime-hamburger').click(function(){
        $(this).toggleClass('open');
    });
});


/************ AFFICHAGE DES MINIATURES AU SCROLL **************/
new AnimOnScroll( document.getElementById( 'grid' ), {
    minDuration : 0.6,
    maxDuration : 0.9,
    viewportFactor : 0.2
} );
