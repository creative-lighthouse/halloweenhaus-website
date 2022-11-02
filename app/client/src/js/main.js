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

    //ListToggleElement
    let listToggleElements = [...document.querySelectorAll('[data-behaviour="list-toggle"]')];
    listToggleElements.forEach((element) => {
        element.addEventListener("click", (e) => {
            e.preventDefault();
            const item = element.parentNode.parentNode;
            item.classList.toggle("list_item--visible")

            listToggleElements.filter(e => e.parentNode.parentNode != item).forEach((e) => {
                e.parentNode.parentNode.classList.remove("list_item--visible")
            });
        })
    });

    //TimelineFilter
    let timelineItems = [...document.querySelectorAll('[data-behaviour="timelineItem"]')];
    let timelineFilters = [...document.querySelectorAll('[data-behaviour="timelineFilter"]')]
    timelineFilters.forEach(filter => {
        var isAvailable = false;
        var isActive = true;
        var checkedType = filter.getAttribute('data-type');
        timelineItems.forEach(item => {
            if(item.getAttribute('data-type') == checkedType){
                isAvailable = true;
            }
        });
        if(!isAvailable){
            filter.classList.add("hidden");
        }

        filter.classList.add("active");
        filter.classList.remove("inactive");

        filter.addEventListener("click", (e) => {
            isActive = !isActive;
            if(isActive){
                filter.classList.add("active");
                filter.classList.remove("inactive");
            } else {
                filter.classList.add("inactive");
                filter.classList.remove("active");
            }

            timelineItems.forEach(item => {
                if(item.getAttribute('data-type') == checkedType){
                    if(isActive){
                        item.classList.add("active");
                        item.classList.remove("inactive");
                    } else {
                        item.classList.add("inactive");
                        item.classList.remove("active");
                    }
                }
            });
        });
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

    //CharacterSlider
    const nextSlide_button = document.querySelector('[data-behaviour="nextSlide"]');
    const prevSlide_button = document.querySelector('[data-behaviour="prevSlide"]');
    const slider_holder = document.querySelector('[data-behaviour="characterSlider"]');
    if( slider_holder != null){
        var currentSlide = 0;
        var maxSlides = slider_holder.childElementCount;
        nextSlide_button.addEventListener('click', () => {
            currentSlide += 1;
            if(currentSlide >= maxSlides){
                currentSlide = 0;
            }
            displaySlider();
        });

        prevSlide_button.addEventListener('click', () => {
            currentSlide -= 1;
            if(currentSlide < 0){
                currentSlide = maxSlides - 1;
            }
            displaySlider();
        });

        function displaySlider(){
            let slides = slider_holder.children;
            let i;
            for(i = 0; i < slides.length; i++){
                if (i < currentSlide) {
                    slides[i].classList.remove("visible");
                    slides[i].classList.remove("right");
                    slides[i].classList.add("left");
                } else if (i > currentSlide) {
                    slides[i].classList.remove("visible");
                    slides[i].classList.add("right");
                    slides[i].classList.remove("left");
                } else {
                    slides[i].classList.add("visible");
                    slides[i].classList.remove("right");
                    slides[i].classList.remove("left");
                }
            }
        }

        displaySlider();
    }

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

        var nextHalloweenDate = '2023-10-31T15:00:00.000Z'; //-2h wegen Zeitverschiebung
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

            halloweenCountdown.innerHTML = 'Noch ' + days + 'd | ' + hours + 'h | ' + minutes + 'm | ' + seconds + 's bis Halloween!';
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
