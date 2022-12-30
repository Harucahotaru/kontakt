<?php

use app\models\ProductsCategories;
use app\widgets\Slides;

$categories = ProductsCategories::getAllCategories();
?>
<div class="menu-item-big">
    <div class="menu-item-sidebar">
        <ul class="menu-item-line">
            <?php $top = 0 ?>
            <?php foreach ($categories as $category): ?>
                <li class="menu-item active" href="#">
                    <div class="menu-text">
                        <div class="menu-text-size-title">
                            <i class="fa-solid fa-plug hover-icon"></i>
                            <?= $category['icon'] ?>
                            <a class="menu-item-text menu-text-size-title"
                               href="/catalog/<?= $category['url_name'] ?>"> <?= $category['name'] ?></a>
                        </div>
                    </div>
                    <div class="menu-item-arrow menu-text-size-title"><i class="fa-solid fa-angle-right"></i></div>
                    <div style="clear: both"></div>
                    <div class="submenu" style="top: <?= $top ?>px">
                        <div class="row">
                            <div class="col-lg-3">
                                <?php foreach ($category['parent_id'] as $parentCategory): ?>
                                    <div class="submenu-item">
                                        <a class="submenu-subcategory-title"
                                           href="/catalog/<?= $category['url_name']
                                           . '/' . $parentCategory['url_name'] ?>">
                                            <?= $parentCategory['name'] ?>
                                        </a>
                                        <ul class="submenu-text">
                                            <?php foreach ($parentCategory['parent_id'] as $submenuParentCategory): ?>
                                                <li class="submenu-category-item">
                                                    <a class="submenu-subcategory-text"
                                                       href="/catalog/<?= $category['url_name']
                                                       . '/' . $parentCategory['url_name']
                                                       . '/' . $submenuParentCategory['url_name'] ?>">
                                                        <?= $submenuParentCategory['name'] ?>
                                                    </a>
                                                </li>
                                                <!--                                    <span class="submenu-subcategory-andmore">Еще //    </span>-->
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </li>
                <?php $top -= 43 ?>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="menu-item-slider">
        <?= Slides::widget() ?>
    </div>
</div>