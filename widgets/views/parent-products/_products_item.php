<?php

/** @var Products $model * */

use app\models\Products;

?>
<div class="product-card my-3">
    <a data-pjax=0 href="/catalog/view/<?= $model->id ?>">
        <div class="<?= empty($model->getThumbnailsPath()) ? 'no-image-product' : '' ?>">
            <section class="swiper-container swiper1 pt-3">
                <div class="swiper-wrapper">
                    <?php foreach ($model->getThumbnailsPath() as $image): ?>
                        <div class="swiper-slide" style="height: 250px">
                            <img style="width: 100%" src="<?= $image ?>" alt=""/>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-pagination swiper1 swiper-pagination-white"></div>
            </section>
        </div>
        <div class="product-card-body">
            <h5 class="product-card-title"><?= $model->name ?></h5>
            <div class="product-card-description"><?= $model->description ?></div>
            <div class="row py-3 row">
                <div class="card-basket col-lg-6">
                </div>
            </div>
        </div>
    </a>
</div>
<script type="module" src="/js/swiper.js"></script>
<script type="module" src="/js/product-list-slider.js"></script>