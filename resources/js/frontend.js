import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Swiper from 'swiper';
import { Autoplay, EffectFade, Navigation, Pagination } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/effect-fade';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

gsap.registerPlugin(ScrollTrigger);

document.addEventListener('DOMContentLoaded', () => {
    initializeHeroSlider();
    initializeScrollReveals();
    initializeHeroMotion();
    initializeServiceCards();
    initializeCounters();
});

function initializeHeroSlider() {
    const slider = document.querySelector('.vtlabs-hero-slider');

    if (!slider) {
        return;
    }

    new Swiper(slider, {
        modules: [
            Autoplay,
            EffectFade,
            Navigation,
            Pagination,
        ],

        loop: slider.querySelectorAll('.swiper-slide').length > 1,
        speed: 1100,
        effect: 'fade',
        fadeEffect: {
            crossFade: true,
        },

        autoplay: {
            delay: 6500,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },

        pagination: {
            el: '.vtlabs-hero-pagination',
            clickable: true,
        },

        navigation: {
            nextEl: '.vtlabs-hero-next',
            prevEl: '.vtlabs-hero-prev',
        },

        on: {
            init(swiper) {
                animateHeroSlide(swiper.slides[swiper.activeIndex]);
            },

            slideChangeTransitionStart(swiper) {
                animateHeroSlide(swiper.slides[swiper.activeIndex]);
            },
        },
    });
}

function animateHeroSlide(slide) {
    if (!slide) {
        return;
    }

    const elements = slide.querySelectorAll('[data-hero-reveal]');

    gsap.killTweensOf(elements);

    gsap.fromTo(
        elements,
        {
            opacity: 0,
            y: 35,
        },
        {
            opacity: 1,
            y: 0,
            duration: 0.9,
            stagger: 0.12,
            ease: 'power3.out',
        },
    );
}

function initializeScrollReveals() {
    const elements = document.querySelectorAll('[data-reveal]');

    if (!elements.length) {
        return;
    }

    elements.forEach((element) => {
        const direction = element.dataset.reveal || 'up';

        let fromProperties = {
            opacity: 0,
            y: 45,
        };

        if (direction === 'left') {
            fromProperties = {
                opacity: 0,
                x: -50,
            };
        }

        if (direction === 'right') {
            fromProperties = {
                opacity: 0,
                x: 50,
            };
        }

        if (direction === 'scale') {
            fromProperties = {
                opacity: 0,
                scale: 0.92,
            };
        }

        gsap.fromTo(
            element,
            fromProperties,
            {
                opacity: 1,
                x: 0,
                y: 0,
                scale: 1,
                duration: 0.9,
                ease: 'power3.out',

                scrollTrigger: {
                    trigger: element,
                    start: 'top 86%',
                    once: true,
                },
            },
        );
    });
}

function initializeHeroMotion() {
    const hero = document.querySelector('[data-hero-motion]');

    if (!hero || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    const layers = hero.querySelectorAll('[data-motion-layer]');

    hero.addEventListener('mousemove', (event) => {
        const bounds = hero.getBoundingClientRect();

        const x = (
            event.clientX - bounds.left - bounds.width / 2
        ) / bounds.width;

        const y = (
            event.clientY - bounds.top - bounds.height / 2
        ) / bounds.height;

        layers.forEach((layer) => {
            const depth = Number(layer.dataset.motionLayer || 20);

            gsap.to(layer, {
                x: x * depth,
                y: y * depth,
                duration: 0.8,
                ease: 'power2.out',
            });
        });
    });

    hero.addEventListener('mouseleave', () => {
        gsap.to(layers, {
            x: 0,
            y: 0,
            duration: 1,
            ease: 'power3.out',
        });
    });
}

function initializeServiceCards() {
    const cards = document.querySelectorAll('[data-service-card]');

    cards.forEach((card) => {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            return;
        }

        card.addEventListener('mousemove', (event) => {
            const bounds = card.getBoundingClientRect();

            const rotateX = (
                event.clientY - bounds.top - bounds.height / 2
            ) / 24;

            const rotateY = -(
                event.clientX - bounds.left - bounds.width / 2
            ) / 24;

            gsap.to(card, {
                rotateX,
                rotateY,
                transformPerspective: 900,
                transformOrigin: 'center',
                duration: 0.35,
                ease: 'power2.out',
            });
        });

        card.addEventListener('mouseleave', () => {
            gsap.to(card, {
                rotateX: 0,
                rotateY: 0,
                duration: 0.6,
                ease: 'power3.out',
            });
        });
    });
}

function initializeCounters() {
    const counters = document.querySelectorAll('[data-counter]');

    counters.forEach((counter) => {
        const target = Number(counter.dataset.counter || 0);

        if (!Number.isFinite(target)) {
            return;
        }

        const state = {
            value: 0,
        };

        gsap.to(state, {
            value: target,
            duration: 1.8,
            ease: 'power2.out',

            scrollTrigger: {
                trigger: counter,
                start: 'top 88%',
                once: true,
            },

            onUpdate() {
                counter.textContent = Math.floor(
                    state.value,
                ).toLocaleString();
            },
        });
    });
}
