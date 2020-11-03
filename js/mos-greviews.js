jQuery(document).ready(function($) {
    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        // nav: true,
        items: 1,
        autoplay:true,
        autoplayTimeout:4000,
        autoplayHoverPause:true,
        // navText: '<>',
        /* responsive: {
            0: {
                items: 1
            },
            1000: {
                items: 2
            }
        } */
    });
    $('.show-full').click(function(e){
        e.preventDefault();
        $(this).closest('.content-area').find('.trimmed-content').hide();
        $(this).closest('.content-area').find('.full-content').show();
    });
    $('.show-trimmed').click(function(e){
        e.preventDefault();
        $(this).closest('.content-area').find('.trimmed-content').show();
        $(this).closest('.content-area').find('.full-content').hide();
    });
});