/*********** ADD IMAGE EDITION ARTICLE ************
(function (s) {

    $('#addimagebtn').click(function (e) {
        e.preventDefault();
        var $clone = $('#addimage').clone().attr('id', '').removeClass('hidden');
        $('#addimage').before($clone);
    })

})***/


/**********SLIDER***************/
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


/*************** STICKY MENU ******************/

