define([
    "jquery"
], function ($) {
    "use strict";

    return function (config) {

        const container = document.getElementById('testimonial');
        const testimonials = document.querySelectorAll('#testimonial figure');
        let count = 0;

        function slide() {
            let mediaWidth = $(window).width() >= 480 ? 720 : 290;
            count++;

            if (count > testimonials.length -1) {
                count = 0;
            }
            container.style.transform = `translate(${-count * mediaWidth}px)`;
        }

        setInterval(slide, 7000);
    }
});
