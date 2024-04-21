jQuery(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/emporio_agrario_shop_carousel_widget.default', function ($scope, $) {
        
        var swiper = new Swiper(".emporio-agrario-shop-products-carousel", {
            // Default settings, these will apply for viewports less than 992px wide
            slidesPerView: 1, // Adjust this value as needed for smaller screens
        
            // Responsive breakpoints
            breakpoints: {
                // when window width is >= 992px
                992: {
                    slidesPerView: 5.5,
                    spaceBetween: 20 // Adjust the space between slides as needed
                }
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
        

    });
});
