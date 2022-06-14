import GLightbox from "glightbox";

document.addEventListener("DOMContentLoaded", function (event) {

    const menu_button = document.querySelector('[data-behaviour="toggle-menu"]');

    menu_button.addEventListener('click', () => {
        document.body.classList.toggle('body--show');
    })

    const lightbox = GLightbox({
        selector: '[data-gallery="gallery"]',
        touchNavigation: true,
        loop: true,
    });

    //Fixed Menu
    window.addEventListener('scroll', () => {

        if (document.documentElement.scrollTop > 30 || document.body.scrollTop > 30){
            document.body.classList.add('menu--fixed');
        } else {
            document.body.classList.remove('menu--fixed');
        }
    })
});
