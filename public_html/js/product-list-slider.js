import Swiper from '/js/swiper.js';

const swiper1 = new Swiper('.swiper1', {
    effect: 'coverflow',
    spaceBetween: 10, // расстояние между слайдами
    coverflowEffect: {
        rotate: 0,
        stretch: 0,
        depth: 0,
    },
    pagination: {
        el: '.swiper-pagination-widget',
    },
});

const swiper2 = new Swiper('.swiper2', {
    effect: 'coverflow',
    spaceBetween: 10, // расстояние между слайдами
    coverflowEffect: {
        rotate: 0,
        stretch: 0,
        depth: 0,
    },
    pagination: {
        el: '.swiper-pagination-widget',
    },
});