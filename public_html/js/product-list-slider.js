import Swiper from '/js/swiper.js';

const swiper = new Swiper('.swiper-container', {
    effect: 'coverflow',
    spaceBetween: 10, // расстояние между слайдами
    coverflowEffect: {
        rotate: 0,
        stretch: 0,
        depth: 0,
    },
    pagination: {
        el: '.swiper-pagination',
    },
});