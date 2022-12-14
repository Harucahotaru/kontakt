<?php

use app\widgets\Slides;

?>
<div class="menu-item-big">
<!--    <div class="menu-item-sidebar">-->
<!--        <ul class="menu-item-line">-->
<!--            <li class="menu-item active" href="#">-->
<!--                <div class="menu-text">-->
<!--                    <div class="menu-text-size-title">-->
<!--                        <i class="fa-solid fa-plug hover-icon"></i>-->
<!--                        <i class="fa-solid fa-car-battery"></i>-->
<!--                        <a class="menu-item-text menu-text-size-title" href="#">Кабели и растяжки</a>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="menu-item-arrow menu-text-size-title"><i class="fa-solid fa-angle-right"></i></div>-->
<!--                <div style="clear: both"></div>-->
<!--                <div class="submenu">-->
<!--                    <div class="row">-->
<!--                        <div class="col-lg-3">-->
<!--                            <div class="submenu-item">-->
<!--                                <span class="submenu-subcategory-title">Заголовок 1</span>-->
<!--                                <ul class="submenu-text">-->
<!--                                    <li class="submenu-category-item">-->
<!--                                        <a class="submenu-subcategory-text" href="\catalog\cabels">Название категории 1</a>-->
<!--                                    </li>-->
<!--                                    <span class="submenu-subcategory-andmore">Еще //    </span>-->
<!--                                </ul>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </li>-->
<!--        </ul>-->
<!--    </div>-->
    <div class="menu-item-slider">
            <?= Slides::widget() ?>
    </div>
</div>