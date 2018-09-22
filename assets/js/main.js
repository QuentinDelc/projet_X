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
    autoplay:true,
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
//Exécute la fonction lors du scroll
window.onscroll = function() {stickyMenu()};

var navbar = document.getElementById("navbar");
//Récupère la position supérieure par rapport au sommet de la page
var sticky = navbar.offsetTop;

function stickyMenu() {
    //Renvoi le nombre de pixel que le document fait actuellement défiler sur l'axe vertical
    if (window.pageYOffset >= sticky) {
        //Ajoute une class lorsque la nav arrive en haut
        navbar.classList.add("sticky")
        //Supprime la class lorsque la nav retrouve sa position initiale
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


/*************** SCROLL TOP *************************/
$(window).scroll(function() {
    // Si la page est scrollé à plus de 800px on ajoute le bouton
    if ($(this).scrollTop() >= 800) {
        $('#return-to-top').fadeIn(200);
    } else {
        // Sinon on enlève le bouton
        $('#return-to-top').fadeOut(200);
    }
});
$('#return-to-top').click(function() {
    // Lorsque l'on click sur le bouton on revient en haut de page
    $('body,html').animate({
        scrollTop : 0
    }, 500);
});
