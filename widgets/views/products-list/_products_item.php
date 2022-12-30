<?php

/** @var \app\models\Products $model * */
?>
<div class="product-card my-3">
    <a href="catalog/view/<?= $model->id ?>">
        <section class="swiper-container pt-3">
            <div class="swiper-wrapper">
                <?php foreach ($model->getThumbnailsPath() as $image): ?>
                    <div class="swiper-slide" style="height: 250px">
                        <img style="width: 100%" src="<?= $image ?>" alt=""/>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination swiper-pagination-white"></div>
        </section>
        <script type="module" src="/js/swiper.js"></script>
        <script type="module" src="/js/product-list-slider.js"></script>
        <div class="product-card-body">
            <h5 class="product-card-title"><?= $model->name ?></h5>
            <div class="product-card-description"><?= $model->description ?></div>
            <div class="row py-3 row">
                <!--            <div class="col-lg-6 card-price -->
                <?php //($model->on_sale == 0) ? '': 'card-price-on-sale'; ?><!--">-->
                <!--                <s class="card-price-past">--><?php //$model->sale?><!--</s>-->
                <!--                --><?php //$model->cost?>
                <!--                <i class="fas fa-ruble-sign card-price-icon"></i>-->
                <!--            </div>-->
                <div class="card-basket col-lg-6">
                </div>
            </div>
            <div class="row">
                <a href="/catalog/view/<?= $model->id ?>" class="col-lg-9 ">
                    <div class="bg-warning product-card-button product-card-button-bottom">На страницу товара</div>
                </a>
                <!--            <div class="col-lg-3">-->
                <!--                <button type="submit" class="product-card-button product-card-button-add bg-warning"-->
                <!--                        data-field="quant[1]">-->
                <!--                    <span class="fas fa-cart-plus"></span>-->
                <!--                </button>-->
                <!--            </div>-->
            </div>
        </div>
    </a>
</div>
