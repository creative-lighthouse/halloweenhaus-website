import GLightbox from "glightbox";
import Swiper from 'swiper/bundle';
import "./eventsNavigator";
import "./posSystem";
import "./statisticsPage";
import "./glossar.js";

document.addEventListener("DOMContentLoaded", function (event) {

    const menu_button = document.querySelector('[data-behaviour="toggle-menu"]');

    //Mobile Menubutton
    if(menu_button != null){
        menu_button.addEventListener('click', () => {
            document.body.classList.toggle('body--show');
        });
    }

    // INIT LIGHTBOX
    const lightboxes = document.querySelectorAll('[data-gallery="gallery"]');

    if (lightboxes.length > 0) {
        lightboxes.forEach((lightbox) => {
            const lightboxselector = lightbox.getAttribute('data-galleryid');
            if (lightbox.getAttribute('data-singleimage') === 'true') {
                lightbox = GLightbox({
                    selector: '[data-galleryid="' + lightboxselector + '"]',
                    draggable: false,
                    keyboardNavigation: false,
                    touchNavigation: false,
                });
            } else {
                lightbox = GLightbox({
                    selector: '[data-galleryid="' + lightboxselector + '"]',
                    touchNavigation: true,
                    loop: true,
                });
            }
        });
    }

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

    timelineItems.forEach(element => {
        let togglers = [...element.getElementsByClassName("timeline_toggle")];
        togglers.forEach(toggler => {
            toggler.addEventListener("click", (e) => {
                e.preventDefault();
                element.classList.toggle("list_item--visible")

                timelineItems.filter(e => e != element).forEach((e) => {
                    e.classList.remove("list_item--visible")
                });
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

    // init default Swipers:
    const sliders = document.querySelectorAll('.swiper');

    sliders.forEach(function (slider) {
        const autoSwiper = slider.classList.contains('swiper--auto');
        const swiper = new Swiper(slider, {
            effect: 'slide',
            direction: 'horizontal',
            loop: true,

            autoplay: autoSwiper ? {
                delay: 5000,
            } : false,

            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    });

    const showsliders = document.querySelectorAll('.showswiper');
    showsliders.forEach(function (slider) {
        const swiper = new Swiper(slider, {
            effect: 'slide',
            direction: 'horizontal',
            loop: false,
            slidesPerView: 1,
            spaceBetween: 10,
            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            // Responsive breakpoints
            breakpoints: {
                500: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                740: {
                    slidesPerView: 3,
                    spaceBetween: 25
                },
                // when window width is >= 1024px
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 30
                },
            }
        });
    });

    const imagesliders = document.querySelectorAll('.imageswiper');
    imagesliders.forEach(function (slider) {
        const swiper = new Swiper(slider, {
            effect: 'slide',
            direction: 'horizontal',
            loop: false,
            slidesPerView: 1,
            spaceBetween: 10,
            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            // Responsive breakpoints
            breakpoints: {
                500: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                740: {
                    slidesPerView: 2,
                    spaceBetween: 25
                },
                // when window width is >= 1024px
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30
                },
            }
        });
    });


    /**
     * Our JavaScript function, which calculates the days, hours,
     * minutes and seconds left until Halloween day.
     */
    const halloweenCountdown = document.querySelector('[data-behaviour="countdown"]');

    function calculateHalloweenCountdown(){
        if(halloweenCountdown != null){
            var now = new Date();
            var currentMonth = (now.getMonth() + 1);
            var currentDay = now.getDate();
            var nextHalloweenYear = now.getFullYear();
            if(currentMonth > 10){
                nextHalloweenYear = nextHalloweenYear + 1;
            }

            var nextHalloweenDate = nextHalloweenYear + '-10-30T23:00:00.000Z'; //-2h wegen Zeitverschiebung
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

                if(days > 0) {
                    halloweenCountdown.innerHTML = 'Noch ' + days + 'd | ' + hours + 'h | ' + minutes + 'm | ' + seconds + 's bis Halloween!';
                } else {
                    halloweenCountdown.innerHTML = 'Noch ' + hours + 'h | ' + minutes + 'm | ' + seconds + 's bis Halloween!';
                }
            }
            else
            {
                halloweenCountdown.innerHTML = 'Happy Halloween!';
            }

            setTimeout(calculateHalloweenCountdown, 1000);
        }
    }

    if(halloweenCountdown != null){
        calculateHalloweenCountdown();
    }

    // How long you want the animation to take, in ms
    const animationDuration = 1000;
    // Calculate how long each ‘frame’ should last if we want to update the animation 60 times per second
    const frameDuration = 1000 / 60;
    // Use that to calculate how many frames we need to complete the animation
    const totalFrames = Math.round( animationDuration / frameDuration );
    // An ease-out function that slows the count as it progresses
    const easeOutQuad = t => t * ( 2 - t );

    // The animation function, which takes an Element
    const animateCountUp = el => {
        let frame = 0;
        const countTo = parseInt( el.dataset.targetvalue, 10 );
        // Start the animation running 60 times per second
        const counter = setInterval( () => {
            frame++;
            // Calculate our progress as a value between 0 and 1
            // Pass that value to our easing function to get our
            // progress on a curve
            const progress = easeOutQuad( frame / totalFrames );
            // Use the progress value to calculate the current count
            const currentCount = Math.round( countTo * progress );

            // If the current count has changed, update the element
            if ( parseInt( el.innerHTML, 10 ) !== currentCount ) {
                el.innerHTML = currentCount;
            }

            // If we’ve reached our last frame, stop the animation
            if ( frame === totalFrames ) {
                clearInterval( counter );
            }
        }, frameDuration );
    };

    const countupNumbers = document.querySelectorAll( '[data-behaviour="countup"]' );
    let numbersCounted = false;
    if(countupNumbers.length > 0) {
        countupNumbers.forEach ( countupNumber => {
            countupNumber.innerHTML = 0;
        });

        window.addEventListener("load", function () {
            if(!numbersCounted){
                if(window.scrollY > countupNumbers[0].offsetTop - window.innerHeight / 3){

                    countupNumbers.forEach ( countupNumber => {
                        animateCountUp( countupNumber );
                        numbersCounted = true;
                    });
                }
            }
        }, false);
    }

    let currentTimeDisplays = document.querySelectorAll('[data-behaviour="currentTime"]');

    function calculateTime(){
        let date = new Date();
        let hours = date.getHours();
        let minutes = date.getMinutes();
        if(minutes < 10){
            minutes = '0' + minutes;
        }
        currentTimeDisplays.forEach((element) => {
            element.innerHTML = hours + ':' + minutes;
        });
        setTimeout(calculateTime, 1000);
    }

    calculateTime();

    const ticketData = document.querySelector('[data-behaviour="ticketData"]');
    const ticketCheck = document.querySelector('[data-behaviour="ticketCheck"]');

    if(ticketCheck != null){
        const ticketTime = ticketData.getAttribute('data-time');
        const ticketDate = new Date(ticketData.getAttribute('data-date'));
        const slotLength = ticketData.getAttribute('data-slotlength');
        const currentDay = new Date();
        const registrationState = ticketData.getAttribute('data-status');

        const timeDifferenceHours = currentDay.getHours() - ticketTime.split(":")[0];
        const timeDifferenceMinutes = (currentDay.getMinutes() - ticketTime.split(":")[1]) + (timeDifferenceHours * 60);

        console.log(timeDifferenceMinutes);
        console.log(slotLength);

        if(registrationState == "Registered"){
            if(ticketDate.toDateString() == currentDay.toDateString()){
                if(timeDifferenceMinutes > 0 && timeDifferenceMinutes < slotLength){
                    ticketCheck.innerHTML = 'TICKET GÜLTIG!';
                    ticketCheck.classList.add("valid");
                } else if (timeDifferenceMinutes < 0){
                    ticketCheck.innerHTML = "NOCH NICHT GÜLTIG! (" + timeDifferenceMinutes + "min)";
                    ticketCheck.classList.add("invalid");
                } else {
                    ticketCheck.innerHTML = "NICHT MEHR GÜLTIG! (+" + (timeDifferenceMinutes - slotLength) + "min)";
                    ticketCheck.classList.add("invalid");
                }
            } else {
                ticketCheck.innerHTML = 'NICHT HEUTE GÜLTIG!';
                ticketCheck.classList.add("invalid");
            }
        } else if(registrationState == "CheckedIn") {
            ticketCheck.innerHTML = 'Bereits eingecheckt!';
            ticketCheck.classList.add("invalid");
        } else {
            ticketCheck.innerHTML = 'UNGÜLTIG!';
            ticketCheck.classList.add("invalid");
        }
    }

    const scanCode = document.querySelector('[data-behaviour="scancode"]');
        const sectionStatus = document.querySelector('[data-behaviour="sectionStatus"]');

    if (scanCode != null) {

        scanCode.addEventListener('click', () => {
            scanCode.classList.add("highlighted");
            sectionStatus.classList.add("outofway");
            setTimeout(() => {
                scanCode.classList.remove("highlighted");
                sectionStatus.classList.remove("outofway");
            }, 5000);
        });
    }
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
