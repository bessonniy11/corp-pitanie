$(document).ready(function () {
    // Header Menu 
    $('.mobile-menu-icon').click(function () {
        $('.header-left-block').slideDown();
    });
    $('.mobile-menu-icon-close').click(function () {
        $('.header-left-block').slideUp();
    });
    if (window.matchMedia('(max-width: 1024px)').matches) {
        $('.header-menu li').click(function () {
            $('.header-left-block').css('display', 'none');
        });
    }

    // Tariff
    // $('.set-card-gallery1').slick({
    //     infinite: true,
    //     fade: true,
    //     slidesToShow: 1,
    //     slidesToScroll: 1,
    //     asNavFor: '.card-gallery-thumbs1'
    // });
    // $('.card-gallery-thumbs1').slick({
    //     vertical: true,
    //     arrows: false,
    //     infinite: true,
    //     swipeToSlide: true,
    //     slidesToShow: 3,
    //     slidesToScroll: 1,
    //     asNavFor: '.set-card-gallery1'
    // });
    // $('.set-card-gallery2').slick({
    //     infinite: true,
    //     fade: true,
    //     slidesToShow: 1,
    //     slidesToScroll: 1,
    //     asNavFor: '.card-gallery-thumbs2'
    // });
    // $('.card-gallery-thumbs2').slick({
    //     vertical: true,
    //     arrows: true,
    //     infinite: true,
    //     slidesToShow: 3,
    //     slidesToScroll: 1,
    //     asNavFor: '.set-card-gallery2'
    // });
    // $('.set-card-gallery3').slick({
    //     infinite: true,
    //     fade: true,
    //     slidesToShow: 1,
    //     slidesToScroll: 1,
    //     asNavFor: '.card-gallery-thumbs3'
    // });
    // $('.card-gallery-thumbs3').slick({
    //     vertical: true,
    //     arrows: true,
    //     infinite: true,
    //     slidesToShow: 3,
    //     draggable: true,
    //     slidesToScroll: 1,
    //     asNavFor: '.set-card-gallery3'
    // });
    // Tarif tabs
    $('.set-tab-nav-item').click(function () {
        var id = $(this).attr('data-tab'),
            content = $('.set-tab-content-item[data-tab="' + id + '"]');


        $('.set-tab-nav-item.active').removeClass('active');
        $(this).addClass('active');

        $('.set-tab-content-item.active').removeClass('active');
        content.addClass('active');
        // $('.set-card-gallery1').slick("setPosition");
        // $('.card-gallery-thumbs1').slick('setPosition');
        // $('.set-card-gallery2').slick("setPosition");
        // $('.card-gallery-thumbs2').slick('setPosition');
        // $('.set-card-gallery3').slick("setPosition");
        // $('.card-gallery-thumbs3').slick('setPosition');
    });


    // profile-tabs
    $('.side-bar__item').click(function () {
        var id = $(this).attr('data-tab'),
            content = $('.side-bar__item[data-tab="' + id + '"]');


        $('.side-bar__item.active').removeClass('active');
        $(this).addClass('active');

        $('.side-bar__item.active').removeClass('active');
        content.addClass('active');
        // $('.set-card-gallery1').slick("setPosition");
        // $('.card-gallery-thumbs1').slick('setPosition');
        // $('.set-card-gallery2').slick("setPosition");
        // $('.card-gallery-thumbs2').slick('setPosition');
        // $('.set-card-gallery3').slick("setPosition");
        // $('.card-gallery-thumbs3').slick('setPosition');
    });

    // Menu tabs
    $('.menu-breakfast-wrapper .menu-nav-tab-item').click(function () {
        var id = $(this).attr('data-tab'),
            content = $('.menu-breakfast-wrapper .menu-content[data-tab="' + id + '"]');

        $('.menu-breakfast-wrapper .menu-nav-tab-item.active').removeClass('active');
        $(this).addClass('active');

        $('.menu-breakfast-wrapper .menu-content.active').removeClass('active');
        content.addClass('active');
    });

    $('.menu-dinner-wrapper .menu-nav-tab-item').click(function () {
        var id = $(this).attr('data-tab'),
            content = $('.menu-dinner-wrapper .menu-content[data-tab="' + id + '"]');

        $('.menu-dinner-wrapper .menu-nav-tab-item.active').removeClass('active');
        $(this).addClass('active');

        $('.menu-dinner-wrapper .menu-content.active').removeClass('active');
        content.addClass('active');
    });

    $('.menu-supper-wrapper .menu-nav-tab-item').click(function () {
        var id = $(this).attr('data-tab'),
            content = $('.menu-supper-wrapper .menu-content[data-tab="' + id + '"]');

        $('.menu-supper-wrapper .menu-nav-tab-item.active').removeClass('active');
        $(this).addClass('active');

        $('.menu-supper-wrapper .menu-content.active').removeClass('active');
        content.addClass('active');
    });

    $('.menu-breakfast-wrapper .menu-arrow-right').click(function () {
        var scroll = $('.menu-breakfast-wrapper .menu-content.active').scrollLeft();
        $('.menu-breakfast-wrapper .menu-content.active').animate({ scrollLeft: scroll + 240 }, 800);
    });
    $('.menu-breakfast-wrapper .menu-arrow-left').click(function () {
        var scroll = $('.menu-breakfast-wrapper .menu-content.active').scrollLeft();
        $('.menu-breakfast-wrapper .menu-content.active').animate({ scrollLeft: scroll - 240 }, 800);
    });

    $('.menu-dinner-wrapper .menu-arrow-right').click(function () {
        var scroll = $('.menu-dinner-wrapper .menu-content.active').scrollLeft();
        $('.menu-dinner-wrapper .menu-content.active').animate({ scrollLeft: scroll + 240 }, 800);
    });
    $('.menu-dinner-wrapper .menu-arrow-left').click(function () {
        var scroll = $('.menu-dinner-wrapper .menu-content.active').scrollLeft();
        $('.menu-dinner-wrapper .menu-content.active').animate({ scrollLeft: scroll - 240 }, 800);
    });

    $('.menu-supper-wrapper .menu-arrow-right').click(function () {
        var scroll = $('.menu-supper-wrapper .menu-content.active').scrollLeft();
        $('.menu-supper-wrapper .menu-content.active').animate({ scrollLeft: scroll + 240 }, 800);
    });
    $('.menu-supper-wrapper .menu-arrow-left').click(function () {
        var scroll = $('.menu-supper-wrapper .menu-content.active').scrollLeft();
        $('.menu-supper-wrapper .menu-content.active').animate({ scrollLeft: scroll - 240 }, 800);
    });

    $('.menu-drink-wrapper .menu-arrow-right').click(function () {
        var scroll = $('.menu-drink-wrapper .menu-content').scrollLeft();
        $('.menu-drink-wrapper .menu-content').animate({ scrollLeft: scroll + 240 }, 800);
    });
    $('.menu-drink-wrapper .menu-arrow-left').click(function () {
        var scroll = $('.menu-drink-wrapper .menu-content').scrollLeft();
        $('.menu-drink-wrapper .menu-content').animate({ scrollLeft: scroll - 240 }, 800);
    });

    // Sliders
    $('.our-clients-block').slick({
        infinite: true,
        slidesToShow: 4,
        draggable: true,
        swipeToSlide: true,
        responsive: [{
            breakpoint: 1024,
            settings: {
                infinite: true,
                slidesToShow: 3,
            }
        },
        {
            breakpoint: 768,
            settings: {
                infinite: true,
                slidesToShow: 2,
            }
        }]
    });
    $('.testimonials-block').slick({
        infinite: true,
        slidesToShow: 1,
    });

    // Text

    $('.show-more').click(function () {
        $('.hidden-text').toggle();
        var text = $('.show-more').text();
        $('.show-more').text(
            text == "Скрыть" ? "Читать далее" : "Скрыть");

    });

    // Popup
    $('.call-to-action').click(function () {
        $('.popup-wrapper').css('display', 'flex');
    });
    $('.close-form').click(function () {
        $('.popup-wrapper').css('display', 'none');
    });
    /* $('.popup-wrapper').click(function () {
        $(this).css('display', 'none');
    }); */
    $('.popup-wrapper').click(function (e) {
        if ($('.popup-wrapper').has(e.target).length === 0) {
            $('.popup-wrapper').css('display', 'none');
        }
    });
});

//=================
//BodyLock
function body_lock(delay) {
    let body = document.querySelector("body");
    if (body.classList.contains('_lock')) {
        body_lock_remove(delay);
    } else {
        body_lock_add(delay);
    }
}
function body_lock_remove(delay) {
    let body = document.querySelector("body");
    if (unlock) {
        let lock_padding = document.querySelectorAll("._lp");
        setTimeout(() => {
            for (let index = 0; index < lock_padding.length; index++) {
                const el = lock_padding[index];
                el.style.paddingRight = '0px';
            }
            body.style.paddingRight = '0px';
            body.classList.remove("_lock");
        }, delay);

        unlock = false;
        setTimeout(function () {
            unlock = true;
        }, delay);
    }
}
function body_lock_add(delay) {
    let body = document.querySelector("body");
    if (unlock) {
        let lock_padding = document.querySelectorAll("._lp");
        for (let index = 0; index < lock_padding.length; index++) {
            const el = lock_padding[index];
            el.style.paddingRight = window.innerWidth - document.querySelector('.wrapper').offsetWidth + 'px';
        }
        body.style.paddingRight = window.innerWidth - document.querySelector('.wrapper').offsetWidth + 'px';
        body.classList.add("_lock");

        unlock = false;
        setTimeout(function () {
            unlock = true;
        }, delay);
    }
}
//=================

//Menu
let iconMenu = document.querySelector(".icon-menu");
if (iconMenu != null) {
    let delay = 500;
    let menuBody = document.querySelector(".nav__list");
    iconMenu.addEventListener("click", function (e) {
        if (unlock) {
            body_lock(delay);
            iconMenu.classList.toggle("_active");
            menuBody.classList.toggle("_active");
        }
    });
};
function menu_close() {
    let iconMenu = document.querySelector(".icon-menu");
    let menuBody = document.querySelector(".menu__body");
    iconMenu.classList.remove("_active");
    menuBody.classList.remove("_active");
}


//Slider


//BildSlider
let sliders = document.querySelectorAll('._swiper');
if (sliders) {
    for (let index = 0; index < sliders.length; index++) {
        let slider = sliders[index];
        if (!slider.classList.contains('swiper-bild')) {
            let slider_items = slider.children;
            if (slider_items) {
                for (let index = 0; index < slider_items.length; index++) {
                    let el = slider_items[index];
                    el.classList.add('swiper-slide');
                }
            }
            let slider_content = slider.innerHTML;
            let slider_wrapper = document.createElement('div');
            slider_wrapper.classList.add('swiper-wrapper');
            slider_wrapper.innerHTML = slider_content;
            slider.innerHTML = '';
            slider.appendChild(slider_wrapper);
            slider.classList.add('swiper-bild');

            if (slider.classList.contains('_swiper_scroll')) {
                let sliderScroll = document.createElement('div');
                sliderScroll.classList.add('swiper-scrollbar');
                slider.appendChild(sliderScroll);
            }
        }
        if (slider.classList.contains('_gallery')) {
            slider.data('lightGallery').destroy(true);
        }
    }
    sliders_bild_callback();
}

function sliders_bild_callback(params) { }

let sliderScrollItems = document.querySelectorAll('._swiper_scroll');
if (sliderScrollItems.length > 0) {
    for (let index = 0; index < sliderScrollItems.length; index++) {
        const sliderScrollItem = sliderScrollItems[index];
        const sliderScrollBar = sliderScrollItem.querySelector('.swiper-scrollbar');
        const sliderScroll = new Swiper(sliderScrollItem, {
            observer: true,
            observeParents: true,
            direction: 'vertical',
            slidesPerView: 'auto',
            freeMode: true,
            scrollbar: {
                el: sliderScrollBar,
                draggable: true,
                snapOnRelease: false
            },
            mousewheel: {
                releaseOnEdges: true,
            },
        });
        sliderScroll.scrollbar.updateSize();
    }
}
// setInterval(function () {
//     Swiper.update();
// }, 100);
if (document.querySelector('.set-card-nav-wrapper')) {
    let gallery1 = new Swiper('.set-card-gallery1', {

        // effect: 'fade',
        // autoplay: {
        //     delay: 5000,
        //     disableOnInteraction: false,
        // },
        navigation: {
            nextEl: ".gallery-button-next-1",
            prevEl: ".gallery-button-prev-1"
        },
        // observer: true,
        // observeParents: true,
        slidesPerView: 1,
        spaceBetween: 5,
        // autoHeight: true,
        speed: 300,
        simulateTouch: true,
        loop: true,
        preloadImages: false,

        breakpoints: {
            480: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 1,
            },
            992: {
                slidesPerView: 1,
            },
        },
        observer: true,
        observeParents: true,
        observeSlideChildren: true
    });
}
if (document.querySelector('.set-card-nav-wrapper')) {
    let gallery2 = new Swiper('.set-card-gallery2', {

        // effect: 'fade',
        // autoplay: {
        //     delay: 5000,
        //     disableOnInteraction: false,
        // },
        navigation: {
            nextEl: ".gallery-button-next-2",
            prevEl: ".gallery-button-prev-2"
        },
        // observer: true,
        // observeParents: true,
        slidesPerView: 1,
        spaceBetween: 5,
        // autoHeight: true,
        speed: 300,
        simulateTouch: true,
        loop: true,
        preloadImages: false,

        breakpoints: {
            480: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 1,
            },
            992: {
                slidesPerView: 1,
            },
        },
        observer: true,
        observeParents: true,
        observeSlideChildren: true
    });
}
if (document.querySelector('.set-card-nav-wrapper')) {
    let gallery3 = new Swiper('.set-card-gallery3', {

        // effect: 'fade',
        // autoplay: {
        //     delay: 5000,
        //     disableOnInteraction: false,
        // },
        navigation: {
            nextEl: ".gallery-button-next-3",
            prevEl: ".gallery-button-prev-3"
        },
        // observer: true,
        // observeParents: true,
        slidesPerView: 1,
        spaceBetween: 5,
        // autoHeight: true,
        speed: 300,
        simulateTouch: true,
        loop: true,
        preloadImages: false,

        breakpoints: {
            480: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 1,
            },
            992: {
                slidesPerView: 1,
            },
        },
        observer: true,
        observeParents: true,
        observeSlideChildren: true
    });
}

if (document.querySelector('.menu-content')) {
    let dishSlider1 = new Swiper('.menu-content-items1', {

        // effect: 'fade',
        // autoplay: {
        //     delay: 5000,
        //     disableOnInteraction: false,
        // },
        navigation: {
            nextEl: ".menu-button-next-1",
            prevEl: ".menu-button-prev-1"
        },
        // observer: true,
        // observeParents: true,
        slidesPerView: 1,
        spaceBetween: 5,
        // autoHeight: true,
        speed: 300,
        simulateTouch: true,
        loop: true,
        preloadImages: false,

        breakpoints: {
            480: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 3,
            },
        },
        observer: true,
        observeParents: true,
        observeSlideChildren: true
    });
}
if (document.querySelector('.menu-content')) {
    let dishSlider2 = new Swiper('.menu-content-items2', {

        // effect: 'fade',
        // autoplay: {
        //     delay: 5000,
        //     disableOnInteraction: false,
        // },
        navigation: {
            nextEl: ".menu-button-next-2",
            prevEl: ".menu-button-prev-2"
        },
        // observer: true,
        // observeParents: true,
        slidesPerView: 1,
        spaceBetween: 5,
        // autoHeight: true,
        speed: 300,
        simulateTouch: true,
        loop: true,
        preloadImages: false,

        breakpoints: {
            480: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 3,
            },
        },
        observer: true,
        observeParents: true,
        observeSlideChildren: true
    });
}
if (document.querySelector('.menu-content')) {
    let dishSlider3 = new Swiper('.menu-content-items3', {

        // effect: 'fade',
        // autoplay: {
        //     delay: 5000,
        //     disableOnInteraction: false,
        // },
        navigation: {
            nextEl: ".menu-button-next-3",
            prevEl: ".menu-button-prev-3"
        },
        // observer: true,
        // observeParents: true,
        slidesPerView: 1,
        spaceBetween: 5,
        // autoHeight: true,
        speed: 300,
        simulateTouch: true,
        loop: true,
        preloadImages: false,

        breakpoints: {
            480: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 3,
            },
        },
        observer: true,
        observeParents: true,
        observeSlideChildren: true
    });
}
if (document.querySelector('.menu-content')) {
    let dishSlider4 = new Swiper('.menu-content-items4', {

        // effect: 'fade',
        // autoplay: {
        //     delay: 5000,
        //     disableOnInteraction: false,
        // },
        navigation: {
            nextEl: ".menu-button-next-4",
            prevEl: ".menu-button-prev-4"
        },
        // observer: true,
        // observeParents: true,
        slidesPerView: 1,
        spaceBetween: 5,
        // autoHeight: true,
        speed: 300,
        simulateTouch: true,
        loop: true,
        preloadImages: false,

        breakpoints: {
            480: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 3,
            },
        },
        observer: true,
        observeParents: true,
        observeSlideChildren: true
    });
}


// if (document.querySelector('.menu-content')) {
//     let dishSlider2 = new Swiper('.menu-content-items', {

//         // effect: 'fade',
//         // autoplay: {
//         //     delay: 5000,
//         //     disableOnInteraction: false,
//         // },

//         navigation: {
//             nextEl: ".swiper-button-next",
//             prevEl: ".swiper-button-prev"
//         },
//         // observer: true,
//         // observeParents: true,
//         slidesPerView: 3,
//         spaceBetween: 5,
//         // autoHeight: true,
//         speed: 300,
//         simulateTouch: true,
//         loop: true,
//         preloadImages: false,

//         breakpoints: {
//             480: {
//                 slidesPerView: 1,
//             },
//             768: {
//                 slidesPerView: 2,
//             },
//             992: {
//                 slidesPerView: 3,
//             },
//         },
//         observer: true,
//         observeParents: true,
//         observeSlideChildren: true
//     });
// }




// if (document.querySelector('.menu-content-2')) {
//     let dishSlider1 = new Swiper('.menu-content-items', {

//         // effect: 'fade',
//         // autoplay: {
//         //     delay: 5000,
//         //     disableOnInteraction: false,
//         // },
//         navigation: {
//             nextEl: ".swiper-button-next",
//             prevEl: ".swiper-button-prev"
//         },
//         // observer: true,
//         // observeParents: true,
//         slidesPerView: 3,
//         spaceBetween: 5,
//         // autoHeight: true,
//         speed: 300,
//         simulateTouch: true,
//         loop: false,
//         preloadImages: false,

//         breakpoints: {
//             480: {
//                 slidesPerView: 1,
//             },
//             768: {
//                 slidesPerView: 3,
//             },
//             992: {
//                 slidesPerView: 3,
//             },
//         },
//     });
// }

// if (document.querySelector('.menu-content')) {
//     let dishSlider2 = new Swiper('.menu-content-items', {

//         // effect: 'fade',
//         autoplay: {
//             delay: 5000,
//             disableOnInteraction: false,
//         },
//         navigation: {
//             nextEl: ".swiper-button-next",
//             prevEl: ".swiper-button-prev"
//         },
//         // observer: true,
//         // observeParents: true,
//         slidesPerView: 5,
//         spaceBetween: 5,
//         // autoHeight: true,
//         speed: 300,
//         simulateTouch: true,
//         loop: false,
//         preloadImages: true,

//         breakpoints: {
//             480: {
//                 slidesPerView: 1,
//             },
//             768: {
//                 slidesPerView: 3,
//             },
//             992: {
//                 slidesPerView: 4,
//             },
//         },
//     });
// }
// if (document.querySelector('.menu-content')) {
//     let dishSlider3 = new Swiper('.menu-content-items', {

//         // effect: 'fade',
//         autoplay: {
//             delay: 5000,
//             disableOnInteraction: false,
//         },
//         navigation: {
//             nextEl: ".swiper-button-next",
//             prevEl: ".swiper-button-prev"
//         },
//         // observer: true,
//         // observeParents: true,
//         slidesPerView: 5,
//         spaceBetween: 5,
//         // autoHeight: true,
//         speed: 300,
//         simulateTouch: true,
//         loop: false,
//         preloadImages: true,

//         breakpoints: {
//             480: {
//                 slidesPerView: 1,
//             },
//             768: {
//                 slidesPerView: 3,
//             },
//             992: {
//                 slidesPerView: 4,
//             },
//         },
//     });
// }


// scrollTo

function scrollTo(elenent) {
    window.scroll({
        left: 0,
        top: elenent.offsetTop - 75,
        behavior: 'smooth'
    })
}
let goto_links = document.querySelectorAll('._goto');
if (goto_links) {
    for (let index = 0; index < goto_links.length; index++) {
        let goto_link = goto_links[index];
        goto_link.addEventListener('click', function (e) {
            let target_block_class = goto_link.getAttribute('href').replace('#', '');
            let target_block = document.querySelector('.' + target_block_class);
            scrollTo(target_block);
            let iconMenu = document.querySelector(".icon-menu");
            let menuBody = document.querySelector(".nav__list");
            iconMenu.classList.remove("_active");
            menuBody.classList.remove("_active");
            e.preventDefault();
        });
    }
}


//BodyLock
function body_lock(delay) {
    let body = document.querySelector("body");
    if (body.classList.contains('_lock')) {
        body_lock_remove(delay);
    } else {
        body_lock_add(delay);
    }
}
function body_lock_remove(delay) {
    let body = document.querySelector("body");
    if (unlock) {
        let lock_padding = document.querySelectorAll("._lp");
        setTimeout(() => {
            for (let index = 0; index < lock_padding.length; index++) {
                const el = lock_padding[index];
                el.style.paddingRight = '0px';
            }
            body.style.paddingRight = '0px';
            body.classList.remove("_lock");
        }, delay);

        unlock = false;
        setTimeout(function () {
            unlock = true;
        }, delay);
    }
}
function body_lock_add(delay) {
    let body = document.querySelector("body");
    if (unlock) {
        let lock_padding = document.querySelectorAll("._lp");
        for (let index = 0; index < lock_padding.length; index++) {
            const el = lock_padding[index];
            el.style.paddingRight = window.innerWidth - document.querySelector('.wrapper').offsetWidth + 'px';
        }
        body.style.paddingRight = window.innerWidth - document.querySelector('.wrapper').offsetWidth + 'px';
        body.classList.add("_lock");

        unlock = false;
        setTimeout(function () {
            unlock = true;
        }, delay);
    }
}
//=================

//POPUP
const popupLinks = document.querySelectorAll('.popup-link');
const body = document.querySelector('body');
const lockPadding = document.querySelectorAll(".lock-padding");

let unlock = true;

const timeout = 300;

if (popupLinks.length > 0) {
    for (let index = 0; index < popupLinks.length; index++) {
        const popupLink = popupLinks[index];
        popupLink.addEventListener("click", function (e) {
            const popupName = popupLink.getAttribute('href').replace('#', '');
            const curentPopup = document.getElementById(popupName);
            popupOpen(curentPopup);
            e.preventDefault();
        });
    }
}
const popupCloseIcon = document.querySelectorAll('.close-popup');
if (popupCloseIcon.length > 0) {
    for (let index = 0; index < popupCloseIcon.length; index++) {
        const el = popupCloseIcon[index];
        el.addEventListener('click', function (e) {
            popupClose(el.closest('.popup'));
            e.preventDefault();
        });
    }
}

function popupOpen(curentPopup) {
    if (curentPopup && unlock) {
        const popupActive = document.querySelector('.popup.open');
        if (popupActive) {
            popupClose(popupActive, false);
        } else {
            bodyLock();
        }
        curentPopup.classList.add('open');
        curentPopup.addEventListener("click", function (e) {
            if (!e.target.closest('.popup__content') || e.target.closest('.popup-change__btn')) {
                popupClose(e.target.closest('.popup'));
            }

        });
    }
}

function popupClose(popupActive, doUnlock = true) {
    if (unlock) {
        popupActive.classList.remove('open');
        if (doUnlock) {
            bodyUnLock();
        }
    }
}

function bodyLock() {
    const lockPaddingValue = window.innerWidth - document.querySelector('.wrapper').offsetWidth + 'px';

    if (lockPadding.length > 0) {
        for (let index = 0; index < lockPadding.length; index++) {
            const el = lockPadding[index];
            el.style.paddingRight = lockPaddingValue;
        }
    }
    body.style.paddingRight = lockPaddingValue;
    body.classList.add('lock');

    unlock = false;
    setTimeout(function () {
        unlock = true;
    }, timeout);
}

function bodyUnLock() {
    setTimeout(function () {
        if (lockPadding.length > 0) {
            for (let index = 0; index < lockPadding.length; index++) {
                const el = lockPadding[index];
                el.style.paddingRight = '0px';
            }
        }
        body.style.paddingRight = '0px';
        body.classList.remove('lock');
    }, timeout);

    unlock = false;
    setTimeout(function () {
        unlock = true;
    }, timeout);
}

document.addEventListener('keydown', function (e) {
    if (e.which === 27) {
        const popupActive = document.querySelector('.popup.open');
        popupClose(popupActive);
    }
});

(function () {
    // проверяем поддержку
    if (!Element.prototype.closest) {
        // реализуем
        Element.prototype.closest = function (css) {
            var node = this;
            while (node) {
                if (node.matches(css)) return node;
                else node = node.parentElement;
            }
            return null;
        };
    }
})();
(function () {
    // проверяем поддержку
    if (!Element.prototype.matches) {
        // определяем свойство
        Element.prototype.matches = Element.prototype.matchesSelector ||
            Element.prototype.webkitMatchesSelector ||
            Element.prototype.mozMatchesSelector ||
            Element.prototype.msMatchesSelector;
    }
})();

$('.message a').click(function () {
    $('form').animate({ height: "toggle", opacity: "toggle" }, "slow");
});


//Tabs
let tabs = document.querySelectorAll("._tabs");
for (let index = 0; index < tabs.length; index++) {
    let tab = tabs[index];
    let tabs_items = tab.querySelectorAll("._tabs-item");
    let tabs_blocks = tab.querySelectorAll("._tabs-block");
    for (let index = 0; index < tabs_items.length; index++) {
        let tabs_item = tabs_items[index];
        tabs_item.addEventListener("click", function (e) {
            for (let index = 0; index < tabs_items.length; index++) {
                let tabs_item = tabs_items[index];
                tabs_item.classList.remove('_active');
                tabs_blocks[index].classList.remove('_active');
            }
            tabs_item.classList.add('_active');
            tabs_blocks[index].classList.add('_active');
            e.preventDefault();
        });
    }
}
let menutabs = document.querySelectorAll("._menutab");
for (let index = 0; index < menutabs.length; index++) {
    let menutab = menutabs[index];
    let tabs_items = menutab.querySelectorAll("._tabs-items");
    let tabs_blocks = menutab.querySelectorAll("._tabs-blocks");
    for (let index = 0; index < tabs_items.length; index++) {
        let tabs_item = tabs_items[index];
        tabs_item.addEventListener("click", function (e) {
            for (let index = 0; index < tabs_items.length; index++) {
                let tabs_item = tabs_items[index];
                tabs_item.classList.remove('_active');
                tabs_blocks[index].classList.remove('_active');
            }
            tabs_item.classList.add('_active');
            tabs_blocks[index].classList.add('_active');
            e.preventDefault();
        });
    }
}

// CHANGE-TARIF
let changeTarif = document.querySelector('.tarif-changed__link');
if (changeTarif) {
    changeTarif.addEventListener('click', function (e) {
        let changeBody = document.querySelector('.tarif-changed__body');
        changeBody.classList.toggle('_active');
        e.preventDefault();

    });
}


let changeMenuItems = document.querySelectorAll('.change_popup__item');
for (let index = 0; index < changeMenuItems.length; index++) {
    let changeMenuItem = changeMenuItems[index];
    changeMenuItem.addEventListener('click', function () {
        changeMenuItem.classList.toggle('hidden');
        // let status = document.querySelectorAll('.change_popup__status');
        // status.innerHTML = "Crehsn";
        // let status = document.querySelectorAll('.change_popup__status');
        // for (let index = 0; index < status.length; index++) {
        //     let stat = status[index];
        //     stat.innerHTML = "Crehsn"
        // }
    });
}