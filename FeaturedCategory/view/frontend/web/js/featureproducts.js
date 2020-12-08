require(['jquery', 'slick', 'domReady!'], function ($) {
    $(document).ready(function () {
        $('.featured-slider').slick({
            dots: false,
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            speed: 1000,
            rows: 3,
            swipeToSlide: true,

            prevArrow: $('#fp-arrow-left'),
            nextArrow: $('#fp-arrow-right')
        });
    });
});
