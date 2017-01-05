$(document).ready(function() {
    $('.jcarousel1-skin-tangos').jcarousel1({
        auto: 4,
        wrap: 'circular',
        initCallback: mycarousel_initCallback        
        //wrap: 'last',
    });
    $('.jcarousel-skin-tango-home').jcarousel();
});
function mycarousel_initCallback(carousel){
    // Disable autoscrolling if the user clicks the prev or next button.
    carousel.buttonNext.bind('click', function() {
    carousel.startAuto(0);
    });

    carousel.buttonPrev.bind('click', function() {
    carousel.startAuto(0);
    });

    // Pause autoscrolling if the user moves with the cursor over the clip.
    carousel.clip.hover(function() {
    carousel.stopAuto();
    }, function() {
    carousel.startAuto();
    });
};