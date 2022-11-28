<?php

/** @var yii\web\View $this */

use app\widgets\BrandList;
use app\widgets\NewsList;
use app\widgets\ProductsList;

$this->title = 'Контакт "Электротовары"';
?>
<!--    <div class="container-grey container-100">-->
<!--        <div class="container container-grey py-4 ">-->
<!--            <div class="row text-center ">-->
<!--                <a class="col-lg-4 menu-text-size-title p-0 " href="#">-->
<!--                    <div class="bg-warning products-button-r products-button">-->
<!--                        <div>Товары по акции</div>-->
<!--                    </div>-->
<!--                </a>-->
<!--                <a class="col-lg-4 menu-text-size-title p-0 " href="#">-->
<!--                    <div class="bg-warning products-button-c products-button">-->
<!--                        <div>Новинки</div>-->
<!--                    </div>-->
<!--                </a>-->
<!--                <a class="col-lg-4 menu-text-size-title p-0 " href="#">-->
<!--                    <div class="bg-warning products-button-l products-button">-->
<!--                        <div>Рекомендуем</div>-->
<!--                    </div>-->
<!--                </a>-->
<!--            </div>-->
<!--            <div class="py-4">-->
<!--                --><?//= ProductsList::widget() ?>
<!--            </div>-->
<!--            <div class="row text-center align-self-center">-->
<!--                <a class="col-lg-4 mx-auto menu-text-size-title p-0 " href="#">-->
<!--                    <div class="bg-warning products-button-c products-button">-->
<!--                        <div>Перейти на страницу</div>-->
<!--                    </div>-->
<!--                </a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <div class="container-100 bg-warning">
        <div class="container bg-warning py-4">
            <h2>Наши приемущества</h2>
            <div class="row p-lg-4">
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-2" style="font-size: 40px">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <div class="col-lg-10">
                            <h4>Техническая поддержка</h4>
                            <p>У нас Вы можете ничего и не покупать, но если Вам надо, мы всегда даем информационную и техническую поддержку от специалистов. А на Новый год каждого посетителя ждет бесплатный подарок!</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-2" style="font-size: 40px">
                            <i class="fa-solid fa-store"></i>
                        </div>
                        <div class="col-lg-10">
                            <h4>Большой выбор</h4>
                            <p>Мы предлагаем своим клиентам большой выбор качественных товаров, доступные большинству покупателей цены и высокий уровень обслуживания.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-2" style="font-size: 40px">
                            <i class="fa-regular fa-face-smile"></i>
                        </div>
                        <div class="col-lg-10">
                            <h4>Дарим позитивный настрой</h4>
                            <p>У нас Вы не только сможете найти необходимый и качественный товар, но и гарантированно уйдете с позитивным настроением</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-grey container-100">
        <div class="container container-grey py-4">
            <h2 class="text-center">Бренды которые мы предлагаем</h2>
            <div class="py-4"><?= BrandList::widget() ?></div>
            <div class="row text-center align-self-center">
<!--                <a class="col-lg-4 mx-auto menu-text-size-title p-0 " href="#">-->
<!--                    <div class="bg-warning products-button-c products-button">-->
<!--                        <div>Все бренды</div>-->
<!--                    </div>-->
<!--                </a>-->
            </div>
        </div>
    </div>
    <div class="container">
        <?= NewsList::widget() ?>
        <div class="row text-center align-self-center">
            <a class="col-lg-4 mx-auto menu-text-size-title p-0 " href="/news">
                <div class="bg-warning products-button-c products-button">
                    <div>На страницу новостей</div>
                </div>
            </a>
        </div>