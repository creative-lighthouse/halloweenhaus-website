import GLightbox from "glightbox";

document.addEventListener("DOMContentLoaded", function (event) {

    const menu_button = document.querySelector('[data-behaviour="toggle-menu"]');

    //Mobile Menubutton
    menu_button.addEventListener('click', () => {
        document.body.classList.toggle('body--show');
    });

    //Gallery
    const lightbox = GLightbox({
        selector: '[data-gallery="gallery"]',
        touchNavigation: true,
        loop: true,
    });

    //Fixed Menu
    window.addEventListener('scroll', () => {
        parallax();
        if (document.documentElement.scrollTop > 30 || document.body.scrollTop > 30){
            document.body.classList.add('menu--fixed');
        } else {
            document.body.classList.remove('menu--fixed');
        }
    });
    parallax();

    /**
     * Our JavaScript function, which calculates the days, hours,
     * minutes and seconds left until Halloween day.
     */
    const halloweenCountdown = document.querySelector('[data-behaviour="countdown"]');

    function calculateHalloweenCountdown(){
        var now = new Date();
        var currentMonth = (now.getMonth() + 1);
        var currentDay = now.getDate();
        var nextHalloweenYear = now.getFullYear();
        if(currentMonth >= 10 && currentDay >= 31){
            nextHalloweenYear = nextHalloweenYear + 1;
        }

        var nextHalloweenDate = nextHalloweenYear + '-10-31T15:00:00.000Z'; //-2h wegen Zeitverschiebung
        var HalloweenDay = new Date(nextHalloweenDate);

        var diffSeconds = Math.floor((HalloweenDay.getTime() - now.getTime()) / 1000);

        var days = 0;
        var hours = 0;
        var minutes = 0;
        var seconds = 0;

        if(currentMonth != 10 || (currentMonth == 10 && currentDay != 31)){
            days = Math.floor(diffSeconds / (3600*24));
            diffSeconds  -= days * 3600 * 24;
            hours   = Math.floor(diffSeconds / 3600);
            diffSeconds  -= hours * 3600;
            minutes = Math.floor(diffSeconds / 60);
            diffSeconds  -= minutes * 60;
            seconds = diffSeconds;

            halloweenCountdown.innerHTML = 'Noch ' + days + 'T | ' + hours + 'h | ' + minutes + 'm | ' + seconds + 's bis Halloween!';
        }
        else
        {
            halloweenCountdown.innerHTML = 'Happy Halloween!';
        }

        setTimeout(calculateHalloweenCountdown, 1000);
    }

    calculateHalloweenCountdown();
});


function parallax() {

    let listParallaxElements = [...document.querySelectorAll('[data-behaviour="parallax"]')];
    //var parallax = document.querySelector('[data-behaviour="parallax"]');
    listParallaxElements.forEach((parallax, i) => {
        var scrolled = window.pageYOffset - (parallax.parentElement.offsetTop);

        // You can adjust the data-speed dataset to set the scroll speed
        var coords = (scrolled * parallax.dataset.speed) + 'px'
        parallax.style.transform = 'translateY(' + coords + ')';
    })
};
